<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        {{-- Sidebar (identik dengan create & index) --}}
        <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Menu Operasional</h2>
                <p class="text-xs text-gray-500">Mitra BOMA</p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('mitra.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition">
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
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Lapangan</h1>
                    <p class="text-sm text-gray-500">Perbarui informasi lapangan: <strong>{{ $facility->name }}</strong></p>
                </div>
                <a href="{{ route('mitra.facilities.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 transition shadow-sm">
                    &larr; Kembali ke Daftar
                </a>
            </div>

            <div class="max-w-3xl bg-white border border-gray-200 rounded-xl shadow-sm p-6 md:p-8">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-xs text-red-700">
                        <p class="font-bold mb-1">Periksa kembali inputan lu, pak:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mitra.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama Lapangan --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lapangan / Fasilitas <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $facility->name) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    </div>

                    {{-- Jenis & Lantai --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Olahraga <span class="text-red-500">*</span></label>
                            <select name="type" id="type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                @foreach(['Futsal','Basketball','Badminton','Padel'] as $opt)
                                    <option value="{{ $opt }}" {{ old('type', $facility->type) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="floor_type" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Lantai <span class="text-red-500">*</span></label>
                            <select name="floor_type" id="floor_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                @foreach(['Vinyl','Interlock','Rumput Sintetis','Semen / Parquet'] as $opt)
                                    <option value="{{ $opt }}" {{ old('floor_type', $facility->floor_type) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label for="price_per_hour" class="block text-sm font-semibold text-gray-700 mb-1">Harga Sewa Per Jam (IDR) <span class="text-red-500">*</span></label>
                        <input type="number" name="price_per_hour" id="price_per_hour" min="0"
                            value="{{ old('price_per_hour', $facility->price_per_hour) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="opening_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Buka GOR</label>
                            <input type="time" name="opening_time" id="opening_time"
                                value="{{ old('opening_time', $facility->opening_time ? \Carbon\Carbon::parse($facility->opening_time)->format('H:i') : '06:00') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <p class="text-xs text-gray-400 mt-1">Default: 06:00 jika dikosongkan</p>
                        </div>
                        <div>
                            <label for="closing_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Tutup GOR</label>
                            <input type="time" name="closing_time" id="closing_time"
                                value="{{ old('closing_time', $facility->closing_time ? \Carbon\Carbon::parse($facility->closing_time)->format('H:i') : '22:00') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <p class="text-xs text-gray-400 mt-1">Default: 22:00 jika dikosongkan</p>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Lapangan</label>
                        @if($facility->image)
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ asset('storage/' . $facility->image) }}" alt="Foto sekarang" class="h-16 w-24 object-cover rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-400">Foto saat ini. Upload baru untuk mengganti.</p>
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi & Catatan Pengelola</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('description', $facility->description) }}</textarea>
                    </div>

                    {{-- Google Maps --}}
                    <div>
                        <label for="gmaps_link" class="block text-sm font-semibold text-gray-700 mb-1">Link Google Maps GOR <span class="text-red-500">*</span></label>
                        <input type="url" name="gmaps_link" id="gmaps_link"
                            value="{{ old('gmaps_link', $facility->gmaps_link) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    </div>

                    {{-- Amenities --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas Pendukung:</label>
                        @php
                            $allAmenities = [
                                'Area Parkir Luas'            => '🅿️ Free Parkir',
                                'Toilet / Ruang Ganti'        => '🚾 Toilet / Ruang Ganti',
                                'Tersedia Makanan dan Minuman' => '🥤 Kantin / F&B',
                                'CCTV Keamanan'               => '📹 Kamera CCTV',
                                'Mushola Tempat Ibadah'       => '🕌 Mushola',
                                'Koneksi Wi-Fi Gratis'        => '📶 Wi-Fi Gratis',
                            ];
                        @endphp
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-gray-50 p-5 rounded-xl border border-gray-200">
                            @foreach($allAmenities as $val => $label)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="amenities[]" value="{{ $val }}"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                        {{ in_array($val, $selectedAmenities ?? []) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('mitra.facilities.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-lg hover:bg-blue-700 shadow transition">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>