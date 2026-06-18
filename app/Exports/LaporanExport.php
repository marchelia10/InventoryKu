<?php
namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        // Mengambil semua data peminjaman beserta relasi user dan perangkat
        return Loan::with(['user', 'device'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi', 
            'Nama Karyawan', 
            'Divisi', 
            'Jenis / Nama Perangkat', 
            'Nomor Seri',
            'Tgl Peminjaman', 
            'Tgl Pengembalian', 
            'Status Akhir'
        ];
    }

    public function map($loan): array
    {
        // Jika belum dialokasikan perangkat, tampilkan jenis barang yang diminta
        $perangkat = $loan->device ? $loan->device->nama_perangkat : $loan->jenis_barang;
        $nomorSeri = $loan->device ? $loan->device->nomor_seri : '-';
        
        return [
            $loan->id,
            $loan->user->name,
            $loan->user->divisi,
            $perangkat,
            $nomorSeri,
            \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d-m-Y'),
            $loan->tanggal_pengembalian ? \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d-m-Y') : 'Belum Kembali',
            $loan->status,
        ];
    }
}
