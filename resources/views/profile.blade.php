<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - BOMA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css')}}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    <header class="navbar bg-accent">
       <a href="{{ route('dashboard') }}"> 
        <div class="logo-container">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60">
            <div class="logo-text">Badan Olahraga<br>Mahasiswa</div>
        </div>
        </a>

        <nav class="nav-links">
            <a href="{{ route('dashboard') }}">Home</a>
            <a href="{{ route('dashboard') }}#profil">Visi-Misi</a>
            <a href="{{ route('dashboard') }}#kategori">Divisi</a>
            <a href="{{ route('jadwal') }}">Jadwal Latihan</a>
            <a href="{{ route('dashboard') }}">Berita</a>
            <a href="{{ route('dashboard') }}">Tentang Kami</a>
        </nav>

        <div class="nav-right">
            <div class="profile-dropdown">
                <a href="#" class="profile-trigger">
                    <i class="fas fa-user-circle"></i> Profile <i class="fas fa-chevron-down small-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('profile.edit') }}" class="dropdown-item-link"><i class="fas fa-user"></i> My Account</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn-link"><i class="fas fa-sign-out-alt"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="profile-container">
        <section class="profile-header">
            <h1>Profil Pengguna</h1>
            <hr class="profile-divider">
        </section>

        <div class="profile-card">
            @if (session('status') === 'profile-updated')
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Profil anda telah diperbarui',
                        showConfirmButton: false,
                        timer: 2500,
                        background: '#ffffff',
                        iconColor: '#008774',
                        customClass: {
                            title: 'swal-title-custom'
                        }
                    });
                </script>
            @endif

<form id="profile-form" method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="form-group">
        <label>Nama Lengkap:</label>
        <input type="text" name="name" class="profile-input" value="{{ old('name', $user->name) }}" disabled>
    </div>
    
    <div class="form-group">
        <label>Alamat Email:</label>
        <input type="email" name="email" class="profile-input" value="{{ old('email', $user->email) }}" disabled>
        <small class="input-note">*Email digunakan untuk login</small>
    </div>

    <div class="form-group">
        <label>Program Studi:</label>
        <input type="text" name="prodi" class="profile-input" value="{{ old('prodi', $user->prodi) }}" disabled>
    </div>

    <div class="form-group">
        <label>No. Telp:</label>
        <input type="text" name="phone" class="profile-input" value="{{ old('phone', $user->phone) }}" disabled>
    </div>

    <div class="button-group">
        <button type="button" id="edit-btn" class="btn-edit">
            <i class="fas fa-edit"></i> Edit Profil
        </button>

        <button type="submit" id="save-btn" class="btn-save">
            Simpan Perubahan
        </button>
        
        <button type="button" id="cancel-btn" class="btn-cancel">
            Batal
        </button>
    </div>
</form>
        </div>
    </main>

    <script src="{{ asset('js/profilEdit.js') }}"></script>
</body>
</html>