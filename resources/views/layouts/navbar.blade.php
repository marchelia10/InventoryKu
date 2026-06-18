<header class="h-16 flex items-center justify-between px-6 bg-[#C7EACD] border-b border-gray-200 shadow-sm shrink-0">
    
    @if(Auth::check() && Auth::user()->role === 'admin')
        <h2 class="text-xl font-semibold text-gray-800">{{ $header ?? 'Dashboard' }}</h2>
        
        <span class="text-gray-700 font-medium">{{ now()->translatedFormat('d F Y') }}</span>

    @elseif(Auth::check() && Auth::user()->role === 'karyawan')
        <div></div> 
        
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-600">{{ Auth::user()->divisi }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-full transition" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
        
    @endif
    
</header>
