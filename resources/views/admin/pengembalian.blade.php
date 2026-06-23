<x-app-layout>
    <x-slot name="header">Proses Pengembalian Perangkat</x-slot>

    @if($pendingCount > 0)
    <div class="mb-6 p-4 bg-orange-100 text-orange-800 border-l-4 border-orange-500 rounded font-medium flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ $pendingCount }} Pengembalian menunggu pemeriksaan fisik perangkat
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-[#C7EACD] p-4 border-b border-[#A3D2AC]">
            <h3 class="text-lg font-bold text-gray-800">Antrian Pengembalian</h3>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Karyawan</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Perangkat</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tanggal Pinjam</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tgl Kembali (Diajukan)</th>
                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                    @php 
                        // Calculate duration
                        $durasi = \Carbon\Carbon::parse($loan->tanggal_peminjaman)->diffInDays($loan->tanggal_pengembalian) . ' Hari';
                        $deviceName = $loan->device ? $loan->device->nama_perangkat . ' (SN: ' . $loan->device->nomor_seri . ')' : $loan->jenis_barang;
                    @endphp
                    
                    <tr class="border-b hover:bg-gray-50 cursor-pointer transition-colors">
                        <td class="py-3 px-4 text-sm">{{ $loan->user->name }}</td>
                        <td class="py-3 px-4 text-sm">{{ $deviceName }}</td>
                        <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-sm text-orange-600 font-semibold">{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-center">
                            <button onclick="showReturnDetail({{ $loan->id }}, '{{ $loan->user->name }}', '{{ $deviceName }}', '{{ $durasi }}')" 
                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                Proses
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($loans->isEmpty())
                <p class="text-center text-gray-500 py-4">Tidak ada antrian pengembalian saat ini.</p>
            @endif
        </div>
    </div>

    <div id="returnDetailCard" class="bg-white rounded-lg shadow-md overflow-hidden hidden transition-all">
        <div class="bg-[#C7EACD] p-4 border-b border-[#A3D2AC]">
            <h3 class="text-lg font-bold text-gray-800" id="detailTitle">Form Pemeriksaan Kondisi</h3>
        </div>
        
        <div class="p-6">
            <form id="processReturnForm" method="POST" action="">
                @csrf
                <div class="grid grid-cols-2 gap-8 mb-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Perangkat Dikembalikan</p>
                            <p class="font-semibold text-lg text-gray-800" id="detailDevice">-</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Fisik Perangkat</label>
                            <select name="kondisi_fisik" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                                <option value="">-- Pilih Kondisi Terkini --</option>
                                <option value="Baik">Baik - Tidak ada kerusakan</option>
                                <option value="Cukup Baik">Cukup Baik - ada goresan kecil</option>
                                <option value="Rusak Ringan">Rusak ringan</option>
                                <option value="Rusak Berat">Rusak berat</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Durasi Peminjaman</p>
                            <p class="font-semibold text-lg text-gray-800" id="detailDuration">-</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelengkapan Aksesoris</label>
                            <select name="kelengkapan" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                                <option value="Lengkap">Lengkap</option>
                                <option value="Tidak Lengkap">Tidak Lengkap</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Kondisi (Opsional)</label>
                    <textarea name="catatan" rows="2" class="w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400" placeholder="Contoh: Layar sedikit tergores di ujung kanan..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('returnDetailCard').classList.add('hidden')" class="mr-3 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded shadow hover:bg-green-700 transition">
                        Konfirmasi Diterima
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showReturnDetail(id, name, device, duration) {
            document.getElementById('returnDetailCard').classList.remove('hidden');
            
            // Populate texts
            document.getElementById('detailTitle').innerText = 'Form Pemeriksaan Kondisi - ' + name;
            document.getElementById('detailDevice').innerText = device;
            document.getElementById('detailDuration').innerText = duration;

            // Set Form Action Route
            document.getElementById('processReturnForm').action = `/admin/proses-pengembalian/${id}`;
            
            // Smooth scroll
            document.getElementById('returnDetailCard').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</x-app-layout>
