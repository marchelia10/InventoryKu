<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        // Mengambil semua perangkat yang statusnya 'Tersedia' untuk dipajang di grid
        $availableDevices = Device::where('status', 'Tersedia')->get();

        return view('karyawan.dashboard', compact('availableDevices'));
    }    

    public function peminjaman()
    {
        $loans = Loan::where('user_id', Auth::id())->latest()->get();
        return view('karyawan.peminjaman.index', compact('loans'));
    }

    public function createPeminjaman()
    {
        return view('karyawan.peminjaman.create');
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required|string',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal_peminjaman' => 'required|date',
        ]);

        Loan::create([
            'user_id' => Auth::id(),
            'jenis_barang' => $request->jenis_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('karyawan.peminjaman')->with('success', 'Pengajuan berhasil dikirim.');
    }

    // Display the page
    public function pengembalian()
    {
        // Fetch loans that are either currently active or already in the return process
        $loans = Loan::where('user_id', Auth::id())->whereIn('status', ['Disetujui', 'Menunggu Pengembalian', 'Dikembalikan'])->latest()->get();
        
        return view('karyawan.pengembalian.index', compact('loans'));
    }

    // Submit the return date
    public function submitPengembalian(Request $request, $id)
    {
        $request->validate(['tanggal_pengembalian' => 'required|date']);

        $loan = Loan::where('user_id', Auth::id())->findOrFail($id);
        
        $loan->update([
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'Menunggu Pengembalian'
        ]);

        return redirect()->back()->with('success', 'Pengembalian berhasil diajukan. Harap serahkan perangkat ke IT.');
    }

    // Export PDF
    public function cetakPdfPengembalian()
    {
        $loans = Loan::where('user_id', Auth::id())->get();
        $pdf = Pdf::loadView('pdf.daftar_pengembalian', compact('loans'));
        return $pdf->download('Riwayat_Pengembalian_' . Auth::user()->name . '.pdf');
    }

    public function riwayat()
    {
        // Hanya mengambil data transaksi milik karyawan yang sedang login
        $history = Loan::with('device')->where('user_id', Auth::id())->latest()->get();

        return view('karyawan.riwayat', compact('history'));
    }

    public function exportRiwayatPdf()
    {
        $user = Auth::user();
        $loans = Loan::with('device')->where('user_id', $user->id)->latest()->get();
        
        $pdf = Pdf::loadView('pdf.bukti_pengajuan', compact('loans', 'user'));
        return $pdf->download('Riwayat_Aset_'.$user->name.'.pdf');
    }
}
