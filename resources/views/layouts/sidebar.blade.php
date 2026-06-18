<aside class="w-64 bg-[#A3D2AC] border-r text-gray-800 flex flex-col h-screen sticky top-0">
    
    <div class="flex-1 overflow-y-auto">
        <div class="h-16 flex items-center px-6 text-xl font-bold border-b border-white/30 shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 inline-block mr-2">
            InventoryKu
        </div>
        <!-- Navigation Menu List -->
        <nav class="mt-4">
            @if(auth()->user()->role === 'admin')
                <!-- ADMIN IT MENUS -->
                
                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- 2. Tambah Perangkat -->
                <a href="{{ route('admin.perangkat') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Tambah Perangkat
                </a>

                <!-- 3. Verifikasi Pengajuan -->
                <a href="{{ route('admin.verifikasi') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verifikasi Pengajuan
                </a>

                <!-- 4. Proses Pengembalian -->
                <a href="{{ route('admin.pengembalian') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Proses Pengembalian
                </a>

                <!-- 5. Rekap Laporan -->
                <a href="{{ route('admin.laporan') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Rekap Laporan
                </a>

                <!-- 6. Pengaturan (Admin) -->
                <a href="{{ route('admin.pengaturan') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors border-t border-white/20 mt-2">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan
                </a>

            @else
                <!-- KARYAWAN MENUS -->
                
                <!-- 1. Dashboard -->
                <a href="{{ route('karyawan.dashboard') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- 2. Peminjaman -->
                <a href="{{ route('karyawan.peminjaman') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Peminjaman
                </a>

                <!-- 3. Pengembalian -->
                <a href="{{ route('karyawan.pengembalian') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Pengembalian
                </a>

                <!-- 4. Riwayat -->
                <a href="{{ route('karyawan.riwayat') }}" class="flex items-center px-6 py-3.5 hover:bg-white/30 font-medium transition-colors border-t border-white/20 mt-2">
                    <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat
                </a>
            @endif
        </nav>
    </div>

    <div class="border-t border-white/30 p-4 bg-white/10 mt-auto">
        @if(auth()->user()->role === 'admin')
            <div class="flex items-center space-x-3 mb-4">
                <div class="bg-gray-800 p-2 rounded-full text-white shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <p class="font-bold text-sm text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-700 truncate">{{ Auth::user()->divisi }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full text-left px-2 py-1.5 text-sm text-red-700 font-semibold hover:bg-red-100 rounded transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar Akun
                </button>
            </form>
        @else
            <a href="{{ route('karyawan.pengaturan') }}" class="flex items-center p-2 hover:bg-white/30 font-medium rounded transition">
                <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Pengaturan
            </a>
        @endif
    </div>
</aside>
