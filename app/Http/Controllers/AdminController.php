<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage; // Ditambahkan untuk membantu menghapus file foto lama

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Metrik Angka Status Perangkat & Transaksi
        $counts = [
            'tersedia'    => Device::where('status', 'Tersedia')->count(),
            'dipinjam'    => Device::where('status', 'Dipinjam')->count(),
            'perbaikan'   => Device::where('status', 'Perbaikan')->count(),
            'menunggu'    => Loan::where('status', 'Menunggu Verifikasi')->count(),
        ];

        // 2. Pengajuan Terbaru (Ambil 3 Data Terakhir)
        $latestLoans = Loan::with('user')->latest()->take(3)->get();

        // 3. Stok Perangkat (Mengelompokkan berdasarkan nama/jenis perangkat untuk rasio tersedia vs total)
        $devices = Device::all();
        $deviceStock = $devices->groupBy('nama_perangkat')->map(function ($group) {
            return [
                'total'     => $group->count(),
                'tersedia'  => $group->where('status', 'Tersedia')->count(),
            ];
        });

        // 4. Aktivitas Terbaru (Simulasi dinamis dari perubahan status transaksi terakhir)
        $activities = Loan::with('user')->latest()->take(3)->get()->map(function($loan) {
            if ($loan->status === 'Menunggu Verifikasi') {
                return "Pengajuan baru dari {$loan->user->name} membutuhkan verifikasi.";
            } elseif ($loan->status === 'Disetujui') {
                return "Pengajuan {$loan->user->name} disetujui oleh IT.";
            } elseif ($loan->status === 'Ditolak') {
                return "Pengajuan {$loan->user->name} ditolak oleh IT.";
            } elseif ($loan->status === 'Menunggu Pengembalian') {
                return "Perangkat dari {$loan->user->name} menunggu pemeriksaan fisik.";
            } else {
                return "Perangkat dari {$loan->user->name} telah diterima kembali.";
            }
        });

        return view('admin.dashboard', compact('counts', 'latestLoans', 'deviceStock', 'activities'));
    }

    public function perangkat()
    {
        $devices = Device::latest()->get();
        return view('admin.perangkat', compact('devices'));
    }

    public function storePerangkat(Request $request)
    {
        $validated = $request->validate([
            'nama_perangkat' => 'required|string',
            'merek' => 'nullable|string',
            'kondisi' => 'required|string',
            'tanggal_pengadaan' => 'nullable|date',
            'jenis_perangkat' => 'required|string',
            'nomor_seri' => 'required|string|unique:devices',
            'status' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('perangkat', 'public');
            $validated['foto'] = $path;
        }

        Device::create($validated);
        return redirect()->route('admin.perangkat')->with('success', 'Perangkat berhasil ditambahkan!');
    }

    // ==========================================
    // FUNGSI BARU: EDIT, UPDATE, & DESTROY
    // ==========================================

    // Membawa data perangkat yang dipilih ke form
    public function editPerangkat($id)
    {
        $devices = Device::latest()->get(); // Tetap ambil semua data untuk tabel
        $editDevice = Device::findOrFail($id); // Ambil spesifik data yang mau diedit
        
        return view('admin.perangkat', compact('devices', 'editDevice'));
    }

    // Memproses data form edit
    public function updatePerangkat(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $validated = $request->validate([
            'nama_perangkat' => 'required|string',
            'merek' => 'nullable|string',
            'kondisi' => 'required|string',
            'tanggal_pengadaan' => 'nullable|date',
            'jenis_perangkat' => 'required|string',
            'nomor_seri' => 'required|string|unique:devices,nomor_seri,' . $device->id, // Abaikan nomor seri sendiri
            'status' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        // Cek jika ada foto baru yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama di storage jika ada
            if ($device->foto && Storage::disk('public')->exists($device->foto)) {
                Storage::disk('public')->delete($device->foto);
            }
            $path = $request->file('foto')->store('perangkat', 'public');
            $validated['foto'] = $path;
        }

        $device->update($validated);

        return redirect()->route('admin.perangkat')->with('success', 'Perangkat berhasil diperbarui!');
    }

    // Memproses penghapusan data
    public function destroyPerangkat($id)
    {
        $device = Device::findOrFail($id);
        
        // Hapus foto di storage sebelum menghapus data di database
        if ($device->foto && Storage::disk('public')->exists($device->foto)) {
            Storage::disk('public')->delete($device->foto);
        }

        $device->delete();

        return redirect()->route('admin.perangkat')->with('success', 'Perangkat berhasil dihapus!');
    }

    // ==========================================
    // AKHIR FUNGSI BARU
    // ==========================================

    // 1. Display the Verifikasi Page
    public function verifikasi(Request $request)
    {
        // Fetch loans with their associated users
        $loans = Loan::with('user')->latest()->get();
        
        // Notification Badge Count
        $pendingCount = Loan::where('status', 'Menunggu Verifikasi')->count();
        
        // Fetch only available devices so the Admin can assign them
        $availableDevices = Device::where('status', 'Tersedia')->get();

        return view('admin.verifikasi', compact('loans', 'pendingCount', 'availableDevices'));
    }

    // 2. Approve Request & Assign Device
    public function approve(Request $request, $id)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'catatan' => 'nullable|string'
        ]);

        $loan = Loan::findOrFail($id);
        $device = Device::findOrFail($request->device_id);

        // Update Loan
        $loan->update([
            'status' => 'Disetujui',
            'device_id' => $device->id, 
            'catatan_admin' => $request->catatan
        ]);

        // Update Device Status
        $device->update(['status' => 'Dipinjam']);

        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan disetujui dan perangkat dialokasikan.');
    }

    // 3. Reject Request
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string'
        ]);

        $loan = Loan::findOrFail($id);

        $loan->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan
        ]);

        return redirect()->route('admin.verifikasi')->with('error', 'Pengajuan telah ditolak.');
    }

    // 4. Download PDF
    public function downloadPdf($id)
    {
        $loan = Loan::with('user')->findOrFail($id);
        
        // Create a simple PDF view
        $pdf = Pdf::loadView('pdf.pengajuan', compact('loan'));
        
        return $pdf->download('Detail_Pengajuan_' . $loan->user->name . '.pdf');
    }

    // 1. Display the Admin Pengembalian Page
    public function pengembalian()
    {
        $loans = Loan::with(['user', 'device'])->where('status', 'Menunggu Pengembalian')->latest()->get();
        $pendingCount = $loans->count();
        
        return view('admin.pengembalian', compact('loans', 'pendingCount'));
    }

    // 2. Process the Physical Return
    public function prosesPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_fisik' => 'required|string',
            'kelengkapan' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        $loan = Loan::findOrFail($id);
        $device = Device::findOrFail($loan->device_id);

        // A. Update the Loan Record
        $loan->update([
            'status' => 'Dikembalikan',
            'catatan_admin' => $request->catatan
        ]);

        // B. Smart Inventory Restocking Logic based on physical condition
        $newDeviceStatus = ($request->kondisi_fisik === 'RusakBerat') ? 'Perbaikan' : 'Tersedia';
        
        $device->update([
            'status' => $newDeviceStatus,
            'kondisi' => $request->kondisi_fisik
        ]);

        return redirect()->route('admin.pengembalian')->with('success', 'Perangkat berhasil dikembalikan ke inventaris.');
    }

    public function laporan(Request $request)
    {
        $query = Loan::with(['user', 'device']);

        // Logika Filter halaman tetap dipertahankan
        if ($request->filled('divisi')) {
            $query->whereHas('user', function($q) use ($request) { 
                $q->where('divisi', $request->divisi); 
            });
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_barang', $request->jenis);
        }

        $allLoans = $query->get();

        // Agregasi Data untuk 5 Kartu KPI
        $metrics = [
            'total' => $allLoans->count(),
            'disetujui' => $allLoans->where('status', 'Disetujui')->count(),
            'ditolak' => $allLoans->where('status', 'Ditolak')->count(),
            'aktif' => $allLoans->whereIn('status', ['Disetujui', 'Menunggu Pengembalian'])->count(),
            'kembali' => $allLoans->where('status', 'Dikembalikan')->count(),
        ];

        // Agregasi Data untuk Grafik Batang Per Divisi
        $divisiData = $allLoans->groupBy(function($loan) { 
            return $loan->user->divisi; 
        })->map->count();

        // Agregasi Data untuk Grafik Batang Per Minggu
        $mingguData = ['M1' => 0, 'M2' => 0, 'M3' => 0, 'M4' => 0];
        foreach($allLoans as $loan) {
            $week = ceil(\Carbon\Carbon::parse($loan->tanggal_peminjaman)->day / 7);
            $week = $week > 4 ? 4 : $week;
            $mingguData['M' . $week]++;
        }

        // Ambil 3 data rekap peminjaman terbaru untuk tabel bawah
        $latestLaporan = Loan::with(['user', 'device'])->latest()->take(3)->get();

        return view('admin.laporan', compact('metrics', 'divisiData', 'mingguData', 'latestLaporan'));
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'Rekap_Laporan_IT_'.date('Y-m-d').'.xlsx');
    }

    public function exportPdf()
    {
        $loans = Loan::with(['user', 'device'])->latest()->get();
        // Load view HTML yang tadi dibuat dan kirim datanya
        $pdf = Pdf::loadView('pdf.laporan_admin', compact('loans'));
        // Download filenya
        return $pdf->download('Laporan_Peminjaman_IT_'.date('Y-m-d').'.pdf');
    }
}