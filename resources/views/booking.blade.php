<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Lapangan - BOMA</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>

@include('partials.navbar')

    <main class="container" style="min-height: 60vh; position: relative; z-index: 1;">
        <section class="hero">
            <div class="hero-text">
                <h1>Sewa Lapangan Lebih Cepat dan Hemat Di Bandung</h1>
                <p>Boma selain daripada untuk branding organisasi, kita juga membuka usaha untuk sewa lapangan agar bisa melatih enterpreneur dan juga mencari pemasukan untuk boma itu sendiri</p>
                <a href="#" class="hero-btn">Lihat Lebih Banyak</a>
                <div class="hero-stats">
                    <i class="fa-solid fa-location-dot" style="color: var(--primary); font-size: 24px;"></i>
                    <span>100 Fields</span>
                </div>
            </div>
            <div class="hero-img-container">
                <div class="hero-img-wrapper">
                    <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Lapangan Hero">
                </div>
            </div>
        </section>

        <section class="filter-wrapper">
            <form action="{{ route('booking') }}" method="GET" class="filter-bar">
                
                <div class="filter-item">
                    <i class="fa-regular fa-calendar main-icon"></i>
                    <input type="date" name="tanggal" id="filterTanggal" class="filter-input" value="{{ request('tanggal') }}">
                </div>

                <div class="filter-item">
                    <i class="fa-solid fa-running main-icon"></i>
                    <select name="cabang" id="filterCabang" class="filter-input">
                        <option value="" {{ !request('cabang') ? 'selected' : '' }}>Semua Cabang</option>
                        @foreach($listCabang as $cb)
                            <option value="{{ $cb }}" {{ request('cabang') == $cb ? 'selected' : '' }}>{{ $cb }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-item">
                    <i class="fa-solid fa-location-dot main-icon"></i>
                    <select name="kecamatan" id="filterKecamatan" class="filter-input">
                        <option value="" {{ !request('kecamatan') ? 'selected' : '' }}>Semua Kecamatan</option>
                        @foreach($listKecamatan as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-search">Search</button>
            </form>
        </section>
        
        <section class="mb-50" style="margin-bottom: 80px;">
            <h2 class="section-title">Lapangan yang Tersedia</h2>
            <div class="grid-banyak">
                
                @forelse($facilities as $item)
                    <a href="/detail-lapangan/{{ $item->id }}" 
                    class="card-link" 
                    data-auth="{{ Auth::check() ? 'true' : 'false' }}"
                    style="text-decoration: none; display: contents;">
                        <div class="card-img-overlay">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Default Image">
                            @endif
                            
                            <div class="badge-price">Rp {{ number_format($item->price_per_hour, 0, ',', '.') }}/Jam</div>
                            <div class="content">
                                <h3>{{ $item->name }}</h3>
                                <p>{{ $item->mitra->brand_name ?? 'Gor BOMA' }} - {{ $item->floor_type }}</p>
                                <small style="color: #cbd5e1; font-size: 11px;">📍 {{ $item->mitra->address ?? 'Bandung' }}</small>
                            </div>
                        </div>
                    </a>
                @empty
                    @endforelse

            </div>
        </section>
    </main>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Suntikan pengaman biar file booking.js tahu user udah login atau belum
        window.isUserLoggedIn = @json(Auth::check());
    </script>
    <script src="{{ asset('js/booking.js') }}"></script>
</body>
</html>