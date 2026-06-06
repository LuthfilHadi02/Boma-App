<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
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
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Lapangan Baru</h1>
                    <p class="text-sm text-gray-500">Daftarkan aset fasilitas olahraga lu ke dalam sistem BOMA.</p>
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

                <form action="{{ route('mitra.facilities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lapangan / Fasilitas <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Lapangan Futsal Interlock Premium" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Olahraga <span class="text-red-500">*</span></label>
                            <select name="type" id="type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                <option value="" disabled selected>-- Pilih Jenis Olahraga --</option>
                                <option value="Futsal">Futsal</option>
                                <option value="Basketball">Basketball</option>
                                <option value="Badminton">Badminton</option>
                                <option value="Padel">Padel</option>
                            </select>
                        </div>
                        <div>
                            <label for="floor_type" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Lantai Lapangan <span class="text-red-500">*</span></label>
                            <select name="floor_type" id="floor_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                <option value="" disabled selected>-- Pilih Jenis Lantai --</option>
                                <option value="Vinyl">Vinyl</option>
                                <option value="Interlock">Interlock</option>
                                <option value="Rumput Sintetis">Rumput Sintetis</option>
                                <option value="Semen / Parquet">Semen / Parquet</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="price_per_hour" class="block text-sm font-semibold text-gray-700 mb-1">Harga Sewa Per Jam (IDR) <span class="text-red-500">*</span></label>
                        <input type="number" name="price_per_hour" id="price_per_hour" min="0" placeholder="100000" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Lapangan</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi & Catatan Pengelola</label>
                        <textarea id="description" name="description" rows="3" placeholder="Contoh: Lapangan futsal dengan sirkulasi udara yang baik, pencahayaan lampu LED terang standar turnamen, dan rompi gratis..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                    </div>

                    <div>
                        <label for="gmaps_link" class="block text-sm font-semibold text-gray-700 mb-1">Link Share Google Maps GOR <span class="text-red-500">*</span></label>
                        <input type="url" name="gmaps_link" id="gmaps_link" placeholder="Buka Google Maps -> Cari GOR -> Klik Bagikan/Share -> Copy Link, lalu paste di sini" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas Pendukung (Centang yang tersedia):</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-gray-50 p-5 rounded-xl border border-gray-200">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="Area Parkir Luas" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">🅿️ Free Parkir</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="Toilet / Ruang Ganti" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">🚾 Toilet / Ruang Ganti</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="Tersedia Makanan dan Minuman" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">🥤 Kantin / F&B</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="Keamanan CCTV" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">📹 Kamera CCTV</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="Mushola Tempat Ibadah" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">🕌 Mushola</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="Koneksi Wi-Fi Gratis" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">📶 Wi-Fi Gratis</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-lg hover:bg-blue-700 shadow transition">
                            🚀 Simpan & Daftarkan Lapangan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>