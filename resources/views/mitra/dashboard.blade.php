<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 font-['Poppins']">
        
        <aside class="w-64 bg-white shadow-md min-h-screen hidden md:block flex-shrink-0">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Menu Operasional</h2>
                <p class="text-xs text-gray-500">Mitra BOMA</p>
            </div>
            <nav class="p-4 space-y-2">
                {{-- 1. Dashboard Utama (Bisa selalu diakses mitra) --}}
                <a href="{{ route('mitra.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg transition">
                    <span class="mr-3 text-base">📊</span> Dashboard Utama
                </a>
                
                {{-- 🔒 BLOK PENGAMAN SAKTI: Hanya terbuka kalau status Mitra sudah Approved --}}
                @if($mitraProfile && ($mitraProfile->status === 'Approved' || $mitraProfile->status === 'approved'))
                    
                    {{-- Menu Kelola Lapangan (Aktif) --}}
                    <a href="{{ route('mitra.facilities.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition">
                        <span class="mr-3 text-base">🏟️</span> Kelola Lapangan
                    </a>
                    
                    {{-- Menu Jadwal Sewa (Aktif & Bebas Bug Kursor) --}}
                    <a href="{{ route('mitra.facilities.jadwal') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition cursor-pointer">
                        <span class="mr-3 text-base">📅</span> Jadwal Sewa
                    </a>

                    {{-- Menu Tarik Dana (Aktif) --}}
                    <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition">
                        <span class="mr-3 text-base">💰</span> Tarik Dana
                    </a>

                @else
                    {{-- 🛑 KONDISI LOCK: Tampilan mode gembok kalau statusnya masih Pending / Belum Approved --}}
                    
                    {{-- Kelola Lapangan Terkunci --}}
                    <button class="w-full flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 rounded-lg cursor-not-allowed text-left" disabled>
                        <span class="mr-3 text-base">🔒</span> Kelola Lapangan (Locked)
                    </button>
                    
                    {{-- Jadwal Sewa Terkunci (Fix Aman Gak Bisa Di-klik Malu-maluin) --}}
                    <button class="w-full flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 rounded-lg cursor-not-allowed text-left" disabled>
                        <span class="mr-3 text-base">🔒</span> Jadwal Sewa (Locked)
                    </button>

                    {{-- Tarik Dana Terkunci --}}
                    <button class="w-full flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 rounded-lg cursor-not-allowed text-left" disabled>
                        <span class="mr-3 text-base">🔒</span> Tarik Dana (Locked)
                    </button>

                @endif
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Mitra Lapangan BOMA</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola operasional bisnis lapangan lu dengan efisien di sini.</p>
                </div>
                <div>
                    @if($mitraProfile)
                        @if($mitraProfile->status === 'Approved' || $mitraProfile->status === 'approved')
                            <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                🟢 Terverifikasi (Siap Berjualan)
                            </span>
                        @else
                            <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                🟡 Menunggu Verifikasi Admin
                            </span>
                        @endif
                    @else
                        <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200 shadow-sm">
                            🔴 Profil Belum Dilengkapi
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-8 border-l-4 border-blue-600">
                <h3 class="text-lg font-bold text-gray-800 mb-3">🏪 Detail Bisnis Anda</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p class="mb-2"><strong class="text-gray-900">Nama Pemilik:</strong> {{ $user->name }}</p>
                        <p><strong class="text-gray-900">Nama Tempat / Brand:</strong> {{ $mitraProfile->brand_name ?? 'Belum Diatur' }}</p>
                    </div>
                    <div>
                        <p class="mb-2"><strong class="text-gray-900">Alamat Fasilitas:</strong> {{ $mitraProfile->address ?? 'Belum Diatur' }}</p>
                        <p><strong class="text-gray-900">Email Akun:</strong> {{ $user->email }}</p>
                    </div>
                </div>
            </div>

            @if($mitraProfile && ($mitraProfile->status === 'Pending_Verification' || $mitraProfile->status === 'pending_verification'))
                
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl shadow-md p-6 text-white mb-8 relative overflow-hidden">
                    <div class="relative z-10 space-y-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-100 backdrop-blur-sm">
                            ⏳ Under Review / Berkas Sedang Ditinjau
                        </span>
                        <h3 class="text-xl font-extrabold">Akses Fitur Jualan Dikunci Sementara, Pak!</h3>
                        <p class="text-xs text-amber-50 leading-relaxed font-light max-w-4xl">
                            Pendaftaran bisnis <span class="font-bold underline">{{ $mitraProfile->brand_name }}</span> sukses direkam di database. Saat ini tim verifikator BOMA UPI Cibiru sedang memvalidasi data rekening bank dan berkas dokumen identitas lu. Begitu status akun lu berubah dinyatakan <span class="font-bold">Approved</span> oleh Admin, semua menu operasional di bawah ini otomatis terbuka lebar!
                        </p>
                        <p class="text-[10px] italic text-amber-200 pt-1">⚡ Lu bakal dapet email pemberitahuan otomatis di HP begitu akun di-approve Admin.</p>
                    </div>
                </div>

            @endif

            <div class="{{ ($mitraProfile && ($mitraProfile->status === 'Approved' || $mitraProfile->status === 'approved')) ? '' : 'opacity-40 pointer-events-none' }}">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dompet Pendapatan</h4>
                                <span class="text-xl">💰</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stat['balance'], 0, ',', '.') }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-xs text-gray-500">Min. Payout: Rp 100.000</span>
                            @if($stat['balance'] >= 100000)
                                <button class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">Tarik Dana</button>
                            @else
                                <button class="px-3 py-1 bg-gray-200 text-gray-400 text-xs font-semibold rounded-lg cursor-not-allowed" disabled>Tarik Dana</button>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Lapangan (Venues)</h4>
                                <span class="text-xl">🏢</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $stat['total_venues'] }} Lapangan</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <a href="{{ route('mitra.facilities.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center">
                                Kelola inventaris lapangan <span class="ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Booking Berjalan</h4>
                                <span class="text-xl">🗓️</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $stat['active_bookings'] }} Jadwal</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center">
                                Lihat kalender sewa <span class="ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border border-gray-200">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Aksi Cepat Operasional</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('mitra.facilities.create') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-300 transition text-center block group">
                            <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">➕</div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Tambah Lapangan Baru</span>
                        </a>
                        <a href="{{ route('mitra.facilities.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-300 transition text-center block group">
                            <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">🏟️</div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Kelola Inventaris</span>
                        </a>
                        <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition text-center block opacity-50 cursor-not-allowed">
                            <div class="text-2xl mb-2">💳</div>
                            <span class="text-sm font-medium text-gray-400">Riwayat Transaksi</span>
                        </a>
                        <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition text-center block opacity-50 cursor-not-allowed">
                            <div class="text-2xl mb-2"></div>
                            <span class="text-sm font-medium text-gray-400">Pengaturan Bank KYC</span>
                        </a>
                    </div>
                </div>

            </div> </main>
    </div>
</x-app-layout>