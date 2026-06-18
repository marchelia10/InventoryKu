<x-app-layout>
    <x-slot name="header">Pengaturan Profil</x-slot>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col items-center justify-center text-center h-fit">
            <div class="bg-gray-100 p-4 rounded-full text-gray-600 mb-4 border border-gray-200 shadow-inner">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h3>
            <p class="text-sm font-semibold px-3 py-1 bg-gray-100 text-gray-600 rounded-full mt-2 uppercase tracking-wider text-xs">
                {{ Auth::user()->role === 'admin' ? 'Admin IT' : 'Karyawan' }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Divisi: {{ Auth::user()->divisi }}</p>

            <div class="border-t w-full mt-6 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 font-bold rounded-lg border border-red-200 hover:bg-red-100 transition flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Keluar dari Aplikasi
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border lg:col-span-2">
            <div class="flex items-center space-x-2 border-b pb-4 mb-6">
                <div class="text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Data Diri</h3>
            </div>

            @php
                // Menentukan rute submission form berdasarkan peran saat ini
                $actionUrl = Auth::user()->role === 'admin' ? route('admin.pengaturan.update') : route('karyawan.pengaturan.update');
            @endphp

            <form method="POST" action="{{ $actionUrl }}">
                @csrf
                @method('patch')

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg p-2.5 text-sm shadow-sm" required autocomplete="name">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Perusahaan</label>
                        <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg p-2.5 text-sm shadow-sm" required autocomplete="username">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon / WhatsApp Active</label>
                        <input id="no_telepon" name="no_telepon" type="text" value="{{ old('no_telepon', Auth::user()->no_telepon) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg p-2.5 text-sm shadow-sm" required>
                        <x-input-error class="mt-2" :messages="$errors->get('no_telepon')" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end border-t pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
