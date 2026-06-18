<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Laptop Tersedia</p>
                <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $counts['tersedia'] }}</h4>
                <p class="text-xs text-gray-400 mt-1">Unit Terdaftar</p>
            </div>
            <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Dipinjam</p>
                <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $counts['dipinjam'] }}</h4>
                <p class="text-xs text-gray-400 mt-1">Unit Terdaftar</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Perbaikan</p>
                <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $counts['perbaikan'] }}</h4>
                <p class="text-xs text-gray-400 mt-1">Unit Terdaftar</p>
            </div>
            <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Menunggu</p>
                <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $counts['menunggu'] }}</h4>
                <p class="text-xs text-gray-400 mt-1">Unit Terdaftar</p>
            </div>
            <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Pengajuan Terbaru
                    </h3>
                    <a href="{{ route('admin.verifikasi') }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded font-semibold transition">Lihat Semua</a>
                </div>
                <div class="divide-y">
                    @foreach($latestLoans as $loan)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gray-100 p-2 rounded-full text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $loan->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $loan->jenis_barang }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $loan->status === 'Menunggu Verifikasi' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">{{ $loan->status }}</span>
                    </div>
                    @endforeach
                    @if($latestLoans->isEmpty())
                        <p class="text-sm text-gray-500 py-3">Tidak ada antrian pengajuan baru.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Stok Perangkat
                    </h3>
                    <a href="{{ route('admin.perangkat') }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded font-semibold transition">Kelola</a>
                </div>
                <div class="space-y-4">
                    @foreach($deviceStock as $name => $stock)
                    @php 
                        $percentage = $stock['total'] > 0 ? ($stock['tersedia'] / $stock['total']) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                            <span>{{ $name }}</span>
                            <span class="text-xs text-gray-500">{{ $stock['tersedia'] }} / {{ $stock['total'] }} Tersedia</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border">
        <h3 class="font-bold text-gray-800 text-lg flex items-center mb-4">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Aktivitas Terbaru
        </h3>
        <div class="space-y-3">
            @foreach($activities as $activity)
            <div class="flex items-center space-x-3 text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <p>{{ $activity }}</p>
            </div>
            @endforeach
            @if($activities->isEmpty())
                <p class="text-sm text-gray-500">Belum ada rekaman log perubahan aktivitas sistem hari ini.</p>
            @endif
        </div>
    </div>
</x-app-layout>
