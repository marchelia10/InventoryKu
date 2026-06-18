<!DOCTYPE html>
<html>
<head>
    <title>Bukti Riwayat Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Riwayat Peminjaman Aset IT - {{ $user->name }}</h2>
        <p>Divisi: {{ $user->divisi }} | Dokumen Resmi Perusahaan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Jenis/Nama Perangkat</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali (Rencana)</th>
                <th>Status Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->device ? $loan->device->nama_perangkat : $loan->jenis_barang }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d F Y') }}</td>
                <td>{{ $loan->tanggal_pengembalian ? \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d F Y') : '-' }}</td>
                <td>{{ $loan->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
