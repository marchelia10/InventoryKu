<x-app-layout>
    <x-slot name="header">Pengembalian Perangkat</x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Daftar Aset Dipinjam</h3>
            <a href="{{ route('karyawan.export.pdf') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded hover:bg-gray-700 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh
            </a>
        </div>

        <table class="min-w-full bg-white border">
            <thead class="bg-[#C7EACD] border-b border-[#A3D2AC]">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Perangkat</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Tanggal Pinjam</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Status</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800">Aksi Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                <tr class="border-b text-sm">
                    <td class="py-3 px-4 font-medium">{{ $loan->jenis_barang }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $loan->status == 'Disetujui' ? 'bg-blue-100 text-blue-800' : ($loan->status == 'Dikembalikan' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800') }}">
                            {{ $loan->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        @if($loan->status == 'Disetujui')
                            <form action="{{ route('karyawan.pengembalian.submit', $loan->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                <input type="date" name="tanggal_pengembalian" class="border-gray-300 rounded text-sm p-1.5" required>
                                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Ajukan</button>
                            </form>
                        @elseif($loan->status == 'Menunggu Pengembalian')
                            <span class="text-gray-500 italic">Menunggu Cek IT...</span>
                        @else
                            <span class="text-green-600 font-semibold">{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y') }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
