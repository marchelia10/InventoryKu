<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800 mb-2">Dashboard</h1>
    </div>

    <div class="w-full overflow-x-auto pb-4 scrollbar-thin">
        <div class="grid grid-cols-3 gap-4" style="min-width: 900px;">
            @foreach($availableDevices as $device)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 w-80 flex flex-col items-center justify-between hover:shadow-md transition">
                <div class="w-full h-36 bg-gray-50 rounded-lg overflow-hidden flex items-center justify-center mb-3">
                    @if($device->foto)
                        <img src="{{ asset('storage/' . $device->foto) }}" alt="Foto Perangkat" class="w-full h-full object-cover">
                    @else
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    @endif
                </div>
                
                <div class="text-center w-full">
                    <h4 class="font-bold text-gray-800 truncate text-base">{{ $device->nama_perangkat }}</h4>
                    <p class="text-xs text-gray-500 mt-1">SN: {{ $device->nomor_seri }}</p>
                </div>
            </div>
            @endforeach

            @if($availableDevices->isEmpty())
                <div class="bg-white p-8 rounded-xl text-center w-full text-gray-500">
                    Belum ada perangkat terdaftar yang berstatus Tersedia saat ini.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
