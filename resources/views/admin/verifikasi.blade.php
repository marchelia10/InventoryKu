<x-app-layout>
    <x-slot name="header">Verifikasi Pengajuan</x-slot>

    <div class="bg-white p-4 rounded-lg shadow-sm mb-4 flex space-x-4 items-center border">
        <input type="text" placeholder="Cari Nama Karyawan..." class="border rounded p-2 text-sm w-1/3">
        <select class="border rounded p-2 text-sm w-1/4">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
            <option value="Disetujui">Disetujui</option>
        </select>
        <select class="border rounded p-2 text-sm w-1/4">
            <option value="">Semua Divisi</option>
            <option value="IT">IT</option>
            <option value="HR">HR</option>
            <option value="Finance">Finance</option>
        </select>
        <button class="px-4 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-700">Filter</button>
    </div>

    @if($pendingCount > 0)
    <div class="mb-6 p-4 bg-orange-100 text-orange-800 border-l-4 border-orange-500 rounded font-medium flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        {{ $pendingCount }} Pengajuan menunggu verifikasi - harap segera tindak lanjuti
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-[#C7EACD] p-4 flex justify-between items-center border-b border-[#A3D2AC]">
            <h3 class="text-lg font-bold text-gray-800">Daftar Pengajuan Masuk</h3>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Divisi</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Perangkat</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tanggal Ajuan</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                    <tr class="border-b hover:bg-gray-50 cursor-pointer transition-colors"
                        onclick="showDetail({{ $loan->id }}, '{{ $loan->user->name }}', '{{ $loan->user->divisi }}', '{{ $loan->jenis_barang }}', '{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d M Y') }}', '{{ $loan->status }}')">
                        
                        <td class="py-3 px-4 text-sm">{{ $loan->user->name }}</td>
                        <td class="py-3 px-4 text-sm">{{ $loan->user->divisi }}</td>
                        <td class="py-3 px-4 text-sm">{{ $loan->jenis_barang }}</td>
                        <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $loan->status == 'Menunggu Verifikasi' ? 'bg-orange-100 text-orange-800' : ($loan->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ $loan->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center space-x-2">
                            <button class="text-green-600 hover:bg-green-100 p-1 rounded" title="Pilih"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                            <button class="text-red-600 hover:bg-red-100 p-1 rounded" title="Abaikan"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="detailCard" class="bg-white rounded-lg shadow-md overflow-hidden hidden transition-all">
        <div class="bg-[#C7EACD] p-4 border-b border-[#A3D2AC]">
            <h3 class="text-lg font-bold text-gray-800" id="detailTitle">Detail Pengajuan - Pilih Baris</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 gap-8 mb-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Karyawan</p>
                        <p class="font-semibold text-lg" id="detailName">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Perangkat Diminta</p>
                        <p class="font-semibold text-lg" id="detailDevice">-</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Divisi</p>
                        <p class="font-semibold text-lg" id="detailDivision">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Dipinjam</p>
                        <p class="font-semibold text-lg" id="detailDate">-</p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-4">
                <form id="approveForm" method="POST" action="">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alokasikan Unit Fisik (Wajib untuk Persetujuan)</label>
                        <select name="device_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Laptop Tersedia --</option>
                            @foreach($availableDevices as $device)
                                <option value="{{ $device->id }}">{{ $device->nama_perangkat }} (SN: {{ $device->nomor_seri }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Verifikasi (Opsional)</label>
                        <textarea name="catatan" rows="2" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 items-center">
                        <a id="btnPdf" href="#" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh PDF
                        </a>
                        
                        <button type="button" onclick="submitReject()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            Tolak Pengajuan
                        </button>
                        
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Setujui Pengajuan
                        </button>
                    </div>
                </form>

                <form id="rejectForm" method="POST" action="" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDetail(id, name, divisi, device, date, status) {
            // Show the card
            document.getElementById('detailCard').classList.remove('hidden');
            
            // Populate Data
            document.getElementById('detailTitle').innerText = 'Detail Pengajuan - ' + name;
            document.getElementById('detailName').innerText = name;
            document.getElementById('detailDivision').innerText = divisi;
            document.getElementById('detailDevice').innerText = device;
            document.getElementById('detailDate').innerText = date;

            // Update URLs dynamically based on the clicked row's ID
            document.getElementById('approveForm').action = `/admin/verifikasi/${id}/approve`;
            document.getElementById('rejectForm').action = `/admin/verifikasi/${id}/reject`;
            document.getElementById('btnPdf').href = `/admin/verifikasi/${id}/pdf`;
            
            // Scroll to detail view smoothly
            document.getElementById('detailCard').scrollIntoView({ behavior: 'smooth' });
        }

        function submitReject() {
            if(confirm('Yakin ingin menolak pengajuan ini?')) {
                document.getElementById('rejectForm').submit();
            }
        }
    </script>
</x-app-layout>
