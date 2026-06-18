<x-app-layout>
    <x-slot name="header">Kelola Perangkat</x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ isset($editDevice) ? 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' : 'M12 4v16m8-8H4' }}"></path>
            </svg>
            {{ isset($editDevice) ? 'Form Edit Perangkat' : 'Form Tambah Perangkat' }}
        </h3>
        
        <form action="{{ isset($editDevice) ? route('admin.perangkat.update', $editDevice->id) : route('admin.perangkat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($editDevice))
                @method('PUT')
            @endif

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Nama Perangkat</label>
                        <input type="text" name="nama_perangkat" value="{{ old('nama_perangkat', $editDevice->nama_perangkat ?? '') }}" class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Merek</label>
                        <input type="text" name="merek" value="{{ old('merek', $editDevice->merek ?? '') }}" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Kondisi</label>
                        <select name="kondisi" class="w-full border rounded p-2">
                            <option value="Baik" {{ old('kondisi', $editDevice->kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="CukupBaik" {{ old('kondisi', $editDevice->kondisi ?? '') == 'CukupBaik' ? 'selected' : '' }}>Cukup Baik</option>
                            <option value="Perbaikan" {{ old('kondisi', $editDevice->kondisi ?? '') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tanggal Pengadaan</label>
                        <input type="date" name="tanggal_pengadaan" value="{{ old('tanggal_pengadaan', $editDevice->tanggal_pengadaan ?? '') }}" class="w-full border rounded p-2">
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Jenis Perangkat</label>
                        <select name="jenis_perangkat" class="w-full border rounded p-2">
                            <option value="Laptop" {{ old('jenis_perangkat', $editDevice->jenis_perangkat ?? '') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Mouse" {{ old('jenis_perangkat', $editDevice->jenis_perangkat ?? '') == 'Mouse' ? 'selected' : '' }}>Mouse</option>
                            <option value="Charger" {{ old('jenis_perangkat', $editDevice->jenis_perangkat ?? '') == 'Charger' ? 'selected' : '' }}>Charger</option>
                            <option value="Tas" {{ old('jenis_perangkat', $editDevice->jenis_perangkat ?? '') == 'Tas' ? 'selected' : '' }}>Tas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nomor Seri</label>
                        <input type="text" name="nomor_seri" value="{{ old('nomor_seri', $editDevice->nomor_seri ?? '') }}" class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Status Awal</label>
                        <select name="status" class="w-full border rounded p-2">
                            <option value="Tersedia" {{ old('status', $editDevice->status ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Dipinjam" {{ old('status', $editDevice->status ?? '') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Maintenance" {{ old('status', $editDevice->status ?? '') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Foto Perangkat</label>
                        <input type="file" name="foto" class="w-full border rounded p-2">
                        @if(isset($editDevice) && $editDevice->foto)
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded p-2">{{ old('keterangan', $editDevice->keterangan ?? '') }}</textarea>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                @if(isset($editDevice))
                    <a href="{{ route('admin.perangkat') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal Edit</a>
                @else
                    <button type="reset" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Reset</button>
                @endif
                <button type="submit" class="px-4 py-2 {{ isset($editDevice) ? 'bg-orange-500 hover:bg-orange-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded">
                    {{ isset($editDevice) ? 'Update Perangkat' : 'Simpan Perangkat' }}
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Daftar Perangkat Terdaftar</h3>
        </div>
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Nama</th>
                    <th class="py-2 px-4 border-b">Jenis</th>
                    <th class="py-2 px-4 border-b">No. Seri</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr class="text-center">
                    <td class="py-2 px-4 border-b">{{ $device->nama_perangkat }}</td>
                    <td class="py-2 px-4 border-b">{{ $device->jenis_perangkat }}</td>
                    <td class="py-2 px-4 border-b">{{ $device->nomor_seri }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $device->status }}</span>
                    </td>
                    <td class="py-2 px-4 border-b space-x-2">
                        <a href="{{ route('admin.perangkat.edit', $device->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        
                        <form action="{{ route('admin.perangkat.destroy', $device->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>