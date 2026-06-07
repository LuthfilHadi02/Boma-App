<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Menu Operasional</h2>
                <p class="text-xs text-gray-500">Mitra BOMA</p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('mitra.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3 text-base">📊</span> Dashboard Utama
                </a>
                <a href="{{ route('mitra.facilities.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
                    <span class="mr-3 text-base">🏟️</span> Kelola Lapangan
                </a>
                <a href="{{ route('mitra.facilities.jadwal') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg transition">
                    <span class="mr-3 text-base">📅</span> Jadwal Sewa
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition">
                    <span class="mr-3 text-base">💰</span> Tarik Dana
                </a>   
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6 md:p-10">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Monitor Jadwal Sewa</h1>
                <p class="text-sm text-gray-500">Berikut adalah daftar mahasiswa yang memesan slot waktu di setiap lapangan olahraga lu, pak.</p>
            </div>

            <div class="space-y-8">
                @foreach($facilities as $facility)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        {{-- Header Lapangan --}}
                        <div class="bg-gradient-to-r from-teal-600 to-teal-700 p-4 text-white flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold">🏟️ {{ $facility->name }}</h3>
                                <p class="text-xs opacity-90">Tipe: {{ $facility->type }} - Lantai: {{ $facility->floor_type }}</p>
                            </div>
                            <span class="bg-white text-teal-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                Total: {{ $facility->bookings->count() }} Jadwal Aktif
                            </span>
                        </div>

                        {{-- Tabel Bookingan Masuk --}}
                        <div class="p-4">
                            @if($facility->bookings->isEmpty())
                                <div class="text-center py-6 text-gray-400 italic text-sm">
                                    📢 Belum ada mahasiswa yang booking/lunas di lapangan ini, pak.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                            <tr>
                                                <th class="py-3 px-4">Nama Pemesan</th>
                                                <th class="py-3 px-4">Tanggal Main</th>
                                                <th class="py-3 px-4">Jam Mulai</th>
                                                <th class="py-3 px-4">Durasi (Sesi)</th>
                                                <th class="py-3 px-4">Total Bayar</th>
                                                <th class="py-3 px-4">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($facility->bookings as $booking)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="py-3 px-4 font-semibold text-gray-900">{{ $booking->user->name }}</td>
                                                    <td class="py-3 px-4 text-gray-700">📅 {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</td>
                                                    <td class="py-3 px-4 text-gray-600 font-mono">🕒 {{ $booking->start_time }}</td>
                                                    <td class="py-3 px-4 text-gray-600">{{ $booking->jumlah_sesi }} Jam</td>
                                                    <td class="py-3 px-4 text-gray-900 font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                                    <td class="py-3 px-4">
                                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                            ✅ Lunas & Deal
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</x-app-layout>