<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 font-['Poppins']">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block flex-shrink-0">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Menu Operasional</h2>
                <p class="text-xs text-gray-500">Mitra BOMA</p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('mitra.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3">📊</span> Dashboard
                </a>
                <a href="{{ route('mitra.bookings.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">
                    <span class="mr-3">📋</span> Booking Masuk
                </a>
                <a href="{{ route('mitra.schedules.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3">📅</span> Jadwal Fasilitas
                </a>
                <a href="{{ route('mitra.reports.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3">💰</span> Laporan Keuangan
                </a>
                <a href="{{ route('mitra.facilities.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3">🏟️</span> Kelola Lapangan
                </a>
                <a href="{{ route('mitra.reviews.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3">⭐</span> Review & Rating
                </a>
                <a href="{{ route('mitra.profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3">🏪</span> Profil Bisnis
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Booking Masuk</h1>
                <p class="text-sm text-gray-500">Konfirmasi atau tolak booking dari pelanggan</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-yellow-400">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Dikonfirmasi</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Booking Hari Ini</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['today'] }}</p>
                </div>
            </div>

            {{-- Filter --}}
            <form method="GET" class="flex gap-3 mb-6">
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input type="date" name="date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" value="{{ request('date') }}">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
                <a href="{{ route('mitra.bookings.index') }}" class="border border-gray-300 px-4 py-2 rounded-lg text-sm text-gray-600">Reset</a>
            </form>

            {{-- Tabel --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Pelanggan</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Fasilitas</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Tanggal</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Waktu</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Total</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Status</th>
                            <th class="text-center px-4 py-3 text-gray-600 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">{{ $booking->user->name ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $booking->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $booking->facility->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                <span class="text-gray-400">—</span>
                                {{ \Carbon\Carbon::parse($booking->end_time ?? $booking->start_time)->format('H:i') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-green-700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @switch($booking->status)
                                    @case('pending')   <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span> @break
                                    @case('confirmed') <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Dikonfirmasi</span> @break
                                    @case('cancelled') <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Dibatalkan</span> @break
                                    @case('completed') <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Selesai</span> @break
                                @endswitch
                            </td>
                            <td class="px-4 py-3">
                                @if($booking->status === 'pending')
                                <div class="flex gap-2 justify-center">
                                    <form method="POST" action="{{ route('mitra.bookings.confirm', $booking) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1.5 rounded-lg transition">
                                            ✓ Konfirmasi
                                        </button>
                                    </form>
                                    <button onclick="document.getElementById('reject-{{ $booking->id }}').classList.toggle('hidden')"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg transition">
                                        ✕ Tolak
                                    </button>
                                </div>
                                <div id="reject-{{ $booking->id }}" class="hidden mt-2">
                                    <form method="POST" action="{{ route('mitra.bookings.reject', $booking) }}" class="flex gap-1">
                                        @csrf
                                        <input type="text" name="reason" placeholder="Alasan penolakan..." required class="border rounded-lg px-2 py-1 text-xs flex-1">
                                        <button type="submit" class="bg-red-600 text-white text-xs px-2 py-1 rounded-lg">Kirim</button>
                                    </form>
                                </div>
                                @else
                                <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-400">
                                <span class="text-4xl block mb-2">📋</span>
                                Belum ada booking masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-4 border-t">
                    {{ $bookings->links() }}
                </div>
            </div>
        </main>
    </div>
</x-app-layout>