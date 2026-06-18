<!DOCTYPE html>
<html>
<head>
    <title>Rekap Laporan Peminjaman Aset IT</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .status { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekapitulasi Laporan Peminjaman Aset IT</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Divisi</th>
                <th>Perangkat (SN)</th>
                <th>Tgl Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $index => $loan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->user->divisi }}</td>
                <td>
                    {{ $loan->device ? $loan->device->nama_perangkat : $loan->jenis_barang }}<br>
                    <small>{{ $loan->device ? $loan->device->nomor_seri : '-' }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d/m/Y') }}</td>
                <td class="status">{{ $loan->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
