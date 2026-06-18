<x-app-layout>
    <x-slot name="header">Form Peminjaman Karyawan</x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
        <h3 class="text-lg font-bold mb-4">Form Pengajuan</h3>
        
        <form action="{{ route('karyawan.peminjaman.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium">Nama Karyawan</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="w-full border rounded p-2 bg-gray-100" readonly>
                </div>
                
                <div>
                    <label class="block text-sm font-medium">Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="w-full border rounded p-2" required placeholder="Contoh: Laptop Windows">
                </div>

                <div>
                    <label class="block text-sm font-medium">Jumlah Barang</label>
                    <input type="number" name="jumlah_barang" class="w-full border rounded p-2" min="1" value="1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('karyawan.peminjaman') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
