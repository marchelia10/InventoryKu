<x-app-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Riwayat</h3>
            <a href="{{ route('karyawan.export.pdf') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded hover:bg-gray-700 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead class="bg-[#C7EACD] border-b border-[#A3D2AC]">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Nama Karyawan</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Jenis Barang</th>
                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-800">Jumlah Barang</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Tanggal Peminjaman</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Tanggal Pengembalian</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800 w-48">Catatan IT</th>
                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-800">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $data)
                    <tr class="border-b text-sm hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 font-medium text-gray-900 align-top">{{ $data->user->name }}</td>
                        <td class="py-3 px-4 text-gray-700 align-top">{{ $data->jenis_barang }}</td>
                        <td class="py-3 px-4 text-center text-gray-700 align-top">{{ $data->jumlah_barang }}</td>
                        <td class="py-3 px-4 text-gray-600 align-top">{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-gray-600 align-top">{{ $data->tanggal_pengembalian ? \Carbon\Carbon::parse($data->tanggal_pengembalian)->format('d M Y') : '-' }}</td>
                        
                        <td class="py-3 px-4 align-top text-gray-700">
                            @if($data->catatan_admin)
                                {{ $data->catatan_admin }}
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 align-top text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold inline-block whitespace-nowrap
                                {{ $data->status === 'Disetujui' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $data->status === 'Ditolak' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $data->status === 'Dikembalikan' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ in_array($data->status, ['Menunggu Verifikasi', 'Menunggu Pengembalian']) ? 'bg-yellow-100 text-yellow-700' : '' }}
                            ">
                                {{ $data->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach

                    @if($history->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500 italic">
                            Belum ada catatan transaksi log aktivitas peminjaman yang terekam.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>