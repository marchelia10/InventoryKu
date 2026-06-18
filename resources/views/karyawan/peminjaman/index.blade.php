<x-app-layout>
    <x-slot name="header">Peminjaman</x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-6">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Daftar Peminjaman</h3>   
        <div class="flex justify-between items-center">     
        <a href="{{ route('karyawan.peminjaman.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajukan Peminjaman
        </a>

        <a href="{{ route('karyawan.export.pdf') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded hover:bg-gray-700 transition flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Unduh
        </a>
        
    </div>
</div>

        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Nama Karyawan</th>
                    <th class="py-2 px-4 border-b">Jenis Barang</th>
                    <th class="py-2 px-4 border-b">Jumlah</th>
                    <th class="py-2 px-4 border-b">Tanggal Peminjaman</th>
                    <th class="py-2 px-4 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                <tr class="text-center">
                    <td class="py-2 px-4 border-b">{{ $loan->user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $loan->jenis_barang }}</td>
                    <td class="py-2 px-4 border-b">{{ $loan->jumlah_barang }}</td>
                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d M Y') }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">{{ $loan->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
