<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Menu Operasional</h2>
                <p class="text-xs text-gray-500">Mitra BOMA</p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('mitra.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition">
                    <span class="mr-3 text-base">📊</span> Dashboard Utama
                </a>
                <a href="{{ route('mitra.facilities.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg transition">
                    <span class="mr-3 text-base">🏟️</span> Kelola Lapangan
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3 text-base">📅</span> Jadwal Sewa
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3 text-base">💰</span> Tarik Dana
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Daftar Lapangan Anda</h1>
                    <p class="text-sm text-gray-500">Berikut adalah daftar aset lapangan yang Anda sewakan di BOMA.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('mitra.dashboard') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 transition shadow-sm">
                        &larr; Balik ke Dashboard
                    </a>
                    <a href="{{ route('mitra.facilities.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center">
                        ➕ Tambah Lapangan Baru
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-lg shadow-sm flex items-center">
                    <span class="mr-2 text-base">✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($facilities as $item)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-lg text-gray-900 leading-tight">{{ $item->name }}</h3>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $item->type }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1 mb-4">
                                <p>🛠️ <span class="font-medium">Lantai:</span> {{ $item->floor_type }}</p>
                                
                                {{-- Menampilkan Jam Operasional Kustom --}}
                                <p>🕒 <span class="font-medium">Jam Ops:</span> 
                                    {{ $item->opening_time ? \Carbon\Carbon::parse($item->opening_time)->format('H:i') : '06:00' }} - 
                                    {{ $item->closing_time ? \Carbon\Carbon::parse($item->closing_time)->format('H:i') : '22:00' }} WIB
                                </p>

                                @if($item->description)
                                    <p class="text-xs text-gray-400 italic mt-2">"{{ Str::limit($item->description, 60) }}"</p>
                                AI-p>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Bagian Footer Card: Harga + Aksi Tombol Edit & Hapus --}}
                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center gap-2">
                            <p class="text-sm font-bold text-gray-900 whitespace-nowrap">
                                Rp {{ number_format($item->price_per_hour, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">/ Jam</span>
                            </p>
                            
                            <div class="flex gap-1.5">
                                <a href="{{ route('mitra.facilities.edit', $item->id) }}"
                                   class="px-2.5 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.facilities.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus lapangan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 text-xs font-semibold text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center">
                        <span class="text-4xl mb-3 block">🏟️</span>
                        <h3 class="text-sm font-medium text-gray-900">Belum ada lapangan</h3>
                        <p class="text-xs text-gray-500 mt-1">Silakan klik tombol "Tambah Lapangan Baru" untuk mulai berjualan.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</x-app-layout>