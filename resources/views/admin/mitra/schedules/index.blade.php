<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 font-['Poppins']">
        <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block flex-shrink-0">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Menu Operasional</h2>
                <p class="text-xs text-gray-500">Mitra BOMA</p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('mitra.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition"><span class="mr-3">📊</span> Dashboard</a>
                <a href="{{ route('mitra.bookings.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition"><span class="mr-3">📋</span> Booking Masuk</a>
                <a href="{{ route('mitra.schedules.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg"><span class="mr-3">📅</span> Jadwal Fasilitas</a>
                <a href="{{ route('mitra.reports.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition"><span class="mr-3">💰</span> Laporan Keuangan</a>
                <a href="{{ route('mitra.facilities.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition"><span class="mr-3">🏟️</span> Kelola Lapangan</a>
                <a href="{{ route('mitra.reviews.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition"><span class="mr-3">⭐</span> Review & Rating</a>
                <a href="{{ route('mitra.profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition"><span class="mr-3">🏪</span> Profil Bisnis</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Jadwal Fasilitas</h1>
                    <p class="text-sm text-gray-500">Atur slot waktu operasional lapangan Anda</p>
                </div>
                <button onclick="document.getElementById('addScheduleModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition">
                    + Tambah Jadwal
                </button>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">✅ {{ session('success') }}</div>
            @endif

            {{-- Jadwal per fasilitas --}}
            @foreach($facilities as $facility)
            <div class="bg-white rounded-xl shadow-sm mb-6">
                <div class="p-4 border-b flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $facility->name }}</h3>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ ucfirst($facility->type) }}</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 py-2 text-gray-600 font-semibold">Hari</th>
                                <th class="text-left px-4 py-2 text-gray-600 font-semibold">Buka</th>
                                <th class="text-left px-4 py-2 text-gray-600 font-semibold">Tutup</th>
                                <th class="text-left px-4 py-2 text-gray-600 font-semibold">Status</th>
                                <th class="text-center px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($schedules->where('facility_id', $facility->id) as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium">{{ $schedule->day_of_week }}</td>
                                <td class="px-4 py-2">{{ $schedule->start_time }}</td>
                                <td class="px-4 py-2">{{ $schedule->end_time }}</td>
                                <td class="px-4 py-2">
                                    @if($schedule->is_available)
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs">Tersedia</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">Tutup</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <form method="POST" action="{{ route('mitra.schedules.destroy', $schedule) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($schedules->where('facility_id', $facility->id)->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-400 text-sm">Belum ada jadwal untuk lapangan ini.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </main>
    </div>

    {{-- Modal Tambah Jadwal --}}
    <div id="addScheduleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Tambah Jadwal</h3>
                <button onclick="document.getElementById('addScheduleModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form method="POST" action="{{ route('mitra.schedules.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fasilitas</label>
                    <select name="facility_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                        <option value="">Pilih fasilitas...</option>
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Hari</label>
                    <select name="day_of_week" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Buka</label>
                        <input type="time" name="start_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Tutup</label>
                        <input type="time" name="end_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('addScheduleModal').classList.add('hidden')"
                        class="flex-1 border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm">Batal</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>