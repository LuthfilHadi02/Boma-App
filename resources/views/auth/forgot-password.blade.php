<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - BOMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /* Gaya Modern Khusus Halaman Forgot Password */
        .login-split-right {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background hijau bawaan BOMA tetap dipertahankan dari login.css */
        }

        .modern-glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 420px;
        }

        .icon-wrapper {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-input-wrapper {
            position: relative;
            margin-top: 8px;
        }

        .modern-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 14px 16px 14px 46px; /* Ruang untuk ikon */
            color: #ffffff;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .modern-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .modern-input:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.05);
        }

        .modern-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
        }

        .modern-btn {
            width: 100%;
            background: #ffffff;
            color: #047857; /* Warna hijau gelap senada dengan background */
            font-weight: 600;
            font-size: 15px;
            padding: 14px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15);
            background: #f8fafc;
        }
    </style>
</head>
<body class="login-body-new">

    <div class="login-split-wrapper">
        
        <div class="login-split-left" style="background-image: url('{{ asset('src/foto_login.jpeg') }}');">
            <div class="login-dark-overlay">
                <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" class="login-center-logo">
            </div>
        </div>

        <div class="login-split-right">
            
            <div class="modern-glass-card">
                
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>

                <h2 style="font-size: 26px; font-weight: 700; margin-bottom: 8px; color: #ffffff; letter-spacing: -0.5px;">Lupa Password?</h2>
                <p style="color: rgba(255, 255, 255, 0.7); font-size: 14px; margin-bottom: 32px; line-height: 1.6;">
                    Santai aja. Masukkan email yang terdaftar, nanti sistem kita kirim instruksi buat bikin password baru.
                </p>

                @if (session('status'))
                    <div style="background-color: rgba(16, 185, 129, 0.2); color: #a7f3d0; padding: 14px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; border: 1px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background-color: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 14px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; border: 1px solid rgba(239, 68, 68, 0.3);">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div>
                        <label style="color: rgba(255, 255, 255, 0.9); font-size: 14px; font-weight: 500;">Alamat Email</label>
                        <div class="modern-input-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="modern-icon"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            <input type="email" name="email" class="modern-input" placeholder="Masukkan email kamu..." value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <button type="submit" class="modern-btn">
                        Kirim Link Reset
                    </button>
                </form>

                <div style="text-align: center; margin-top: 32px;">
                    <a href="{{ route('login') }}" style="color: rgba(255, 255, 255, 0.6); font-size: 14px; text-decoration: none; font-weight: 500; transition: 0.3s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='rgba(255, 255, 255, 0.6)'">
                        &larr; Kembali ke halaman Login
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>