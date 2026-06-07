<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    </head>
<body>

    {{-- ============ NAVBAR ============ --}}
@include('partials.navbar')

    {{-- ============ HERO ============ --}}
    <div class="profile-hero">
        <div class="avatar-ring">
            <i class="fa-solid fa-user"></i>
        </div>
        <h1>{{ $user->name }}</h1>
        <div class="role-badge">{{ strtoupper($user->role ?? 'member') }}</div>
        <p class="since">Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</p>
    </div>

    {{-- ============ STAT STRIP ============ --}}
    @php
        $totalBooking   = \App\Models\Booking::where('user_id', $user->id)->count();
        $confirmedCount = \App\Models\Booking::where('user_id', $user->id)->where('status','confirmed')->count();
        $pendingCount   = \App\Models\Booking::where('user_id', $user->id)->where('status','pending')->count();
    @endphp
    <div class="stat-strip">
        <div class="stat-item">
            <div class="num">{{ $totalBooking }}</div>
            <div class="lbl">Total Booking</div>
        </div>
        <div class="stat-item">
            <div class="num">{{ $confirmedCount }}</div>
            <div class="lbl">Terkonfirmasi</div>
        </div>
        <div class="stat-item">
            <div class="num">{{ $pendingCount }}</div>
            <div class="lbl">Menunggu Bayar</div>
        </div>
    </div>

    {{-- ============ MAIN LAYOUT ============ --}}
    <div class="profile-wrapper">

        {{-- ---- SIDEBAR ---- --}}
        <div class="profile-sidebar">

            {{-- Navigasi --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">Menu Akun</div>
                <div class="sidebar-nav">
                    <a href="{{ route('profile.edit') }}" class="active">
                        <i class="fa-solid fa-user"></i> Profil Saya
                    </a>
                    <a href="{{ route('booking.history') }}">
                        <i class="fa-solid fa-receipt"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('home') }}">
                        <i class="fa-solid fa-house"></i> Kembali ke Home
                    </a>
                    <a href="{{ route('booking') }}">
                        <i class="fa-solid fa-store"></i> Booking Lapangan
                    </a>
                </div>
            </div>

            {{-- Info ringkas akun --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">Ringkasan Akun</div>
                <div style="padding: 12px 16px;">
                    <div class="info-row">
                        <div class="icon-wrap"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value" style="font-size:0.8rem; word-break:break-all;">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="icon-wrap"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <div class="info-label">Role</div>
                            <div class="info-value">
                                @php $roleClass = ['admin'=>'badge-admin','mitra'=>'badge-mitra'][$user->role] ?? 'badge-user'; @endphp
                                <span class="badge-status {{ $roleClass }}">{{ ucfirst($user->role ?? 'user') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="icon-wrap"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <div class="info-label">No. WhatsApp</div>
                            <div class="info-value" style="font-size:0.82rem;">{{ $user->phone ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Logout --}}
            <div class="sidebar-card">
                <div class="sidebar-logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout dari Akun
                        </button>
                    </form>
                </div>
            </div>

        </div>
        {{-- ---- END SIDEBAR ---- --}}

        {{-- ---- MAIN CONTENT ---- --}}
        <div class="profile-main">

            {{-- Flash message --}}
            @if(session('status') === 'profile-updated')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Profil kamu berhasil diperbarui.',
                            showConfirmButton: false,
                            timer: 2500,
                            confirmButtonColor: '#008774'
                        });
                    });
                </script>
            @endif

            @if ($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:14px 18px;border-radius:12px;font-size:0.875rem;">
                    <strong>Ada yang perlu dibenerin:</strong>
                    <ul style="margin:6px 0 0;padding-left:18px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CARD EDIT PROFIL --}}
            <div class="content-card">
                <div class="content-card-header">
                    <div>
                        <h3><i class="fa-solid fa-pen-to-square" style="color:#008774;margin-right:8px;"></i>Edit Profil</h3>
                        <p>Perbarui informasi pribadi kamu di sini</p>
                    </div>
                </div>
                <div class="content-card-body">
                    <form id="profile-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="field-group">
                            <div class="field-wrap">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" disabled required>
                            </div>
                            <div class="field-wrap">
                                <label>Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" disabled required>
                            </div>
                        </div>
                        <div class="field-group">
                            <div class="field-wrap">
                                <label>Program Studi</label>
                                <input type="text" name="prodi" value="{{ old('prodi', $user->prodi) }}" placeholder="Misal: Pendidikan Jasmani" disabled>
                            </div>
                            <div class="field-wrap">
                                <label>No. Telp / WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" disabled>
                            </div>
                        </div>

                        <div class="btn-row">
                            <button type="button" id="edit-btn" class="btn-edit-profile" onclick="enableEdit()">
                                <i class="fa-solid fa-pen"></i> Edit Profil
                            </button>
                            <button type="submit" id="save-btn" class="btn-save-profile">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                            </button>
                            <button type="button" id="cancel-btn" class="btn-cancel-profile" onclick="cancelEdit()">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CARD GANTI PASSWORD --}}
            <div class="content-card">
                <div class="content-card-header">
                    <div>
                        <h3><i class="fa-solid fa-lock" style="color:#008774;margin-right:8px;"></i>Keamanan Akun</h3>
                        <p>Kelola password akun kamu</p>
                    </div>
                </div>
                <div class="content-card-body">
                    <p class="pw-note">
                        Untuk menjaga keamanan akun, gunakan password yang kuat dan unik. Jangan pernah share password kamu ke siapapun ya, bray.
                    </p>
                    <a href="{{ route('password.request') }}" class="btn-change-pw">
                        <i class="fa-solid fa-key"></i> Ganti Password
                    </a>
                </div>
            </div>

            {{-- CARD RIWAYAT BOOKING TERBARU --}}
            <div class="content-card">
                <div class="content-card-header">
                    <div>
                        <h3><i class="fa-solid fa-clock-rotate-left" style="color:#008774;margin-right:8px;"></i>Booking Terbaru</h3>
                        <p>3 booking terakhir kamu</p>
                    </div>
                </div>
                <div class="content-card-body">
                    @php
                        $recentBookings = \App\Models\Booking::with('facility')
                            ->where('user_id', $user->id)
                            ->latest()->take(3)->get();
                    @endphp

                    @forelse($recentBookings as $bk)
                        @php
                            $dotClass = match($bk->status) {
                                'confirmed' => 'dot-confirmed',
                                'cancelled' => 'dot-cancelled',
                                default     => 'dot-pending',
                            };
                            $dotLabel = match($bk->status) {
                                'confirmed' => '✅ Terkonfirmasi',
                                'cancelled' => '❌ Dibatalkan',
                                default     => '⏳ Pending',
                            };
                        @endphp
                        <div class="booking-mini">
                            <div class="bm-icon"><i class="fa-solid fa-flag-checkered"></i></div>
                            <div>
                                <div class="bm-title">{{ $bk->facility->name ?? 'Lapangan' }}</div>
                                <div class="bm-sub">
                                    {{ \Carbon\Carbon::parse($bk->booking_date)->translatedFormat('d M Y') }}
                                    · {{ \Carbon\Carbon::parse($bk->start_time)->format('H:i') }} WIB
                                    · {{ $bk->jumlah_sesi }} Jam
                                </div>
                            </div>
                            <div class="bm-right">
                                <div class="bm-price">Rp {{ number_format($bk->total_price, 0, ',', '.') }}</div>
                                <span class="status-dot {{ $dotClass }}">{{ $dotLabel }}</span>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:24px 0;color:#9ca3af;font-size:0.875rem;">
                            <i class="fa-solid fa-calendar-xmark" style="font-size:2rem;margin-bottom:8px;display:block;color:#d1d5db;"></i>
                            Belum ada booking nih. Yuk cari lapangan!
                        </div>
                    @endforelse

                    @if($totalBooking > 0)
                        <a href="{{ route('booking.history') }}" class="view-all-link">
                            Lihat Semua Pesanan <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- ============================================================
                🚀 CARD MAIN 4: SUNTIKAN BARU JADWAL LATIHAN YANG DIIKUTI
            ============================================================ --}}
            <div class="content-card" style="margin-top: 10px;">
                <div class="content-card-header">
                    <div>
                        <h3><i class="fa-solid fa-running" style="color:#008774; margin-right:8px;"></i> Agenda Jadwal Latihan Aktif</h3>
                        <p>Daftar kelas program latihan olahraga yang lu ikuti di BOMA.</p>
                    </div>
                </div>
                <div class="content-card-body">
                    @php
                        // 🚀 REAL QUERY BANTAI BUG: Ambil jadwal latihan si user dari table schedules lewat pivot schedule_user bray
                        $myLatihans = \App\Models\User::find($user->id)
                            ->belongsToMany(\App\Models\Schedule::class, 'schedule_user', 'user_id', 'schedule_id')
                            ->withTimestamps()
                            ->latest('schedules.created_at')
                            ->take(3)
                            ->get();
                    @endphp

                    @forelse($myLatihans->take(3) as $latih)
                        <div class="booking-mini">
                            <div class="bm-icon">
                                <i class="fa-solid {{ match(strtolower($latih->cabang ?? '')) {
                                    'basket' => 'fa-basketball',
                                    'badminton' => 'fa-badge-bd',
                                    default => 'fa-dumbbell'
                                } }}"></i>
                            </div>
                            <div>
                                <div class="bm-title">Program Latihan: {{ $latih->nama_program ?? $latih->nama }}</div>
                                <div class="bm-sub">
                                    📍 {{ $latih->lokasi ?? 'GOR UPI Cibiru' }} 
                                    · <strong style="color: #008774;">{{ $latih->hari ?? 'Setiap Hari' }}</strong>
                                </div>
                            </div>
                            <div class="bm-right">
                                <div class="bm-price" style="font-size: 0.8rem; color: #64748b;">Jam Mulai</div>
                                <span class="status-dot dot-confirmed">⏰ {{ \Carbon\Carbon::parse($latih->jam)->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:24px 0; color:#9ca3af; font-size:0.875rem;">
                            <i class="fa-solid fa-calendar-minus" style="font-size:2rem; margin-bottom:8px; display:block; color:#d1d5db;"></i>
                            Lu belum gabung ke jadwal latihan program mana pun nih bray.
                        </div>
                    @endforelse

                    <a href="{{ route('jadwal.index') }}" class="view-all-link">
                        Cari & Ikuti Program Latihan <i class="fa-solid fa-circle-plus" style="margin-left: 4px;"></i>
                    </a>
                </div>
            </div>

        </div>
        {{-- ---- END MAIN CONTENT ---- --}}

    </div>

@include('partials.footer-mini')

    <script>
        function enableEdit() {
            document.querySelectorAll('#profile-form input').forEach(i => i.disabled = false);
            document.getElementById('edit-btn').style.display   = 'none';
            document.getElementById('save-btn').style.display   = 'inline-flex';
            document.getElementById('cancel-btn').style.display = 'inline-flex';
        }
        function cancelEdit() {
            document.querySelectorAll('#profile-form input').forEach(i => i.disabled = true);
            document.getElementById('edit-btn').style.display   = 'inline-flex';
            document.getElementById('save-btn').style.display   = 'none';
            document.getElementById('cancel-btn').style.display = 'none';
        }
    </script>

</body>
</html>