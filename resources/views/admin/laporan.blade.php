<x-app-layout>
    <x-slot name="header">Rekap Laporan Peminjaman</x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex space-x-4 items-center border">
        <input type="date" class="border rounded p-2 text-sm w-1/4">
        <select class="border rounded p-2 text-sm w-1/4">
            <option value="">Semua Divisi</option>
            <option value="IT">IT</option>
            <option value="HR">HR</option>
            <option value="Finance">Finance</option>
        </select>
        <select class="border rounded p-2 text-sm w-1/4">
            <option value="">Semua Jenis Perangkat</option>
            <option value="Laptop">Laptop</option>
            <option value="Aksesoris">Aksesoris</option>
        </select>
        <button class="px-6 py-2 bg-gray-800 text-white rounded font-medium hover:bg-gray-700 transition">Filter Data</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-5 rounded shadow-sm">
            <p class="text-sm font-semibold text-gray-600">Total Pengajuan</p>
            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $metrics['total'] }}</h4>
        </div>
        <div class="bg-green-50 border-l-4 border-green-500 p-5 rounded shadow-sm">
            <p class="text-sm font-semibold text-gray-600">Disetujui</p>
            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $metrics['disetujui'] }}</h4>
        </div>
        <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded shadow-sm">
            <p class="text-sm font-semibold text-gray-600">Ditolak</p>
            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $metrics['ditolak'] }}</h4>
        </div>
        <div class="bg-orange-50 border-l-4 border-orange-500 p-5 rounded shadow-sm">
            <p class="text-sm font-semibold text-gray-600">Aktif Dipinjam</p>
            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $metrics['aktif'] }}</h4>
        </div>
        <div class="bg-teal-50 border-l-4 border-teal-500 p-5 rounded shadow-sm">
            <p class="text-sm font-semibold text-gray-600">Sudah Kembali</p>
            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $metrics['kembali'] }}</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengajuan per Minggu</h3>
            <div class="h-64">
                <canvas id="mingguChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengajuan per Divisi</h3>
            <div class="h-64">
                <canvas id="divisiChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="bg-[#C7EACD] p-4 border-b border-[#A3D2AC]">
            <h3 class="text-lg font-bold text-gray-800">Detail Rekap Peminjaman</h3>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Karyawan</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Perangkat</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tanggal Pinjam</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tanggal Kembali</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestLaporan as $lap)
                    <tr class="border-b text-sm hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">{{ $lap->user->name }}</td>
                        <td class="py-3 px-4">{{ $lap->device ? $lap->device->nama_perangkat : $lap->jenis_barang }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($lap->tanggal_peminjaman)->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ $lap->tanggal_pengembalian ? \Carbon\Carbon::parse($lap->tanggal_pengembalian)->format('d M Y') : '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="font-medium text-blue-600">{{ $lap->status }}</span>
                        </td>
                        <td class="py-3 px-4">{{ $lap->status == 'Dikembalikan' && $lap->device ? $lap->device->kondisi : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Blok Tombol Export -->
    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end space-x-4">
        <!-- Tombol PDF -->
        <a href="{{ route('admin.laporan.export.pdf') }}" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-lg shadow-sm hover:bg-red-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Download Laporan (PDF)
        </a>

        <a href="{{ route('admin.laporan.export.excel') }}" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-lg shadow-sm hover:bg-green-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export Rekap (Excel)
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Render Grafik Batang Mingguan
            const ctxMinggu = document.getElementById('mingguChart').getContext('2d');
            new Chart(ctxMinggu, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($mingguData)) !!},
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: {!! json_encode(array_values($mingguData)) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Render Grafik Batang Divisi
            const ctxDivisi = document.getElementById('divisiChart').getContext('2d');
            new Chart(ctxDivisi, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($divisiData->toArray())) !!},
                    datasets: [{
                        label: 'Volume Pengajuan',
                        data: {!! json_encode(array_values($divisiData->toArray())) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</x-app-layout>
