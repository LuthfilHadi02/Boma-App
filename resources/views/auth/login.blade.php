<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BOMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /* === FULL OVERRIDE — Glass Login === */

        .login-body-new { background-color: #008773; }

        .login-split-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #008773;
        }

        .login-form-box {
            width: 100% !important;
            max-width: 420px !important;
            background: rgba(255,255,255,0.07) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255,255,255,0.18) !important;
            border-radius: 24px !important;
            padding: 40px !important;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3) !important;
        }

        /* Toggle pill */
        .login-toggle-pill {
            display: flex !important;
            background: rgba(255,255,255,0.10) !important;
            border: 1px solid rgba(255,255,255,0.18) !important;
            border-radius: 12px !important;
            padding: 4px !important;
            margin-bottom: 28px !important;
            gap: 4px !important;
        }
        .toggle-pill-btn {
            flex: 1 !important;
            padding: 10px 0 !important;
            border: none !important;
            border-radius: 9px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s !important;
            background: transparent !important;
            color: rgba(255,255,255,0.55) !important;
            font-family: 'Inter', sans-serif !important;
        }
        .toggle-pill-btn.active {
            background: #ffffff !important;
            color: #047857 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        }
        .toggle-pill-btn:not(.active):hover {
            color: #ffffff !important;
            background: rgba(255,255,255,0.12) !important;
        }

        /* Labels */
        .login-input-group { margin-bottom: 20px !important; }
        .login-input-group label {
            display: block !important;
            color: rgba(255,255,255,0.9) !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            margin-bottom: 8px !important;
        }

        /* Input wrapper */
        .login-input-line {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            border-bottom: none !important;
            gap: 0 !important;
            padding-bottom: 0 !important;
        }

        /* Leading icon */
        .login-input-line > svg:first-child {
            position: absolute !important;
            left: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: rgba(255,255,255,0.55) !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        /* Eye icon */
        .login-input-line .icon {
            position: absolute !important;
            right: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: rgba(255,255,255,0.55) !important;
            cursor: pointer !important;
            line-height: 0 !important;
            z-index: 2 !important;
            display: flex !important;
            align-items: center !important;
        }
        .login-input-line .icon:hover { color: #ffffff !important; }

        /* Input field — full override */
        .login-input-line input,
        .login-input-line input[type="email"],
        .login-input-line input[type="password"],
        .login-input-line input[type="text"] {
            width: 100% !important;
            flex: none !important;
            background: rgba(255,255,255,0.08) !important;
            border: 1px solid rgba(255,255,255,0.18) !important;
            border-bottom: 1px solid rgba(255,255,255,0.18) !important;
            border-radius: 12px !important;
            padding: 13px 44px 13px 44px !important;
            color: #ffffff !important;
            font-size: 15px !important;
            font-family: 'Inter', sans-serif !important;
            outline: none !important;
            transition: all 0.3s !important;
            box-sizing: border-box !important;
            box-shadow: none !important;
        }
        .login-input-line input::placeholder {
            color: rgba(255,255,255,0.38) !important;
        }
        .login-input-line input:focus {
            background: rgba(255,255,255,0.13) !important;
            border-color: rgba(255,255,255,0.45) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.06) !important;
            border-radius: 12px !important;
        }

        /* Remember & Forgot */
        .login-options-row {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            margin-bottom: 6px !important;
        }
        .login-remember {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 13px !important;
            color: rgba(255,255,255,0.7) !important;
            cursor: pointer !important;
        }
        .login-remember span { color: rgba(255,255,255,0.7) !important; }
        .login-remember input[type="checkbox"] {
            accent-color: #ffffff !important;
            width: 15px !important; height: 15px !important;
        }
        .login-forgot {
            color: rgba(255,255,255,0.6) !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: color 0.2s !important;
        }
        .login-forgot:hover { color: #ffffff !important; }

        /* Submit button */
        .login-btn-submit {
            width: 100% !important;
            background: #ffffff !important;
            color: #047857 !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            padding: 14px !important;
            border-radius: 12px !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.3s !important;
            margin-top: 22px !important;
            margin-bottom: 0 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
            font-family: 'Inter', sans-serif !important;
        }
        .login-btn-submit:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
            background: #f0fdf4 !important;
        }

        /* Social area */
        .login-social-area { text-align: center !important; margin-top: 24px !important; }
        .login-social-area p {
            color: rgba(255,255,255,0.45) !important;
            font-size: 13px !important;
            margin-bottom: 14px !important;
            position: relative !important;
        }
        .login-social-area p::before,
        .login-social-area p::after {
            content: '' !important;
            position: absolute !important;
            top: 50% !important;
            width: 35% !important;
            height: 1px !important;
            background: rgba(255,255,255,0.15) !important;
        }
        .login-social-area p::before { left: 0 !important; }
        .login-social-area p::after  { right: 0 !important; }
        .login-social-icons {
            display: flex !important;
            justify-content: center !important;
            gap: 14px !important;
        }
        .login-social-icons svg {
            background: rgba(255,255,255,0.09) !important;
            border: 1px solid rgba(255,255,255,0.16) !important;
            border-radius: 10px !important;
            padding: 8px !important;
            cursor: pointer !important;
            transition: all 0.3s !important;
            box-sizing: content-box !important;
        }
        .login-social-icons svg:hover {
            background: rgba(255,255,255,0.18) !important;
            transform: translateY(-2px) !important;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .login-form-box {
                padding: 28px 20px !important;
                max-width: 100% !important;
            }
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
            <div class="login-form-box">

                <div class="login-toggle-pill">
                    <button class="toggle-pill-btn active">Login</button>
                    <button class="toggle-pill-btn" onclick="window.location.href='{{ route('register') }}'">Register</button>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if ($errors->any())
                        <div style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:12px 12px 12px 20px;margin-bottom:18px;font-size:14px;">
                            <ul style="padding-left:16px;margin:0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="login-input-group">
                        <label>Email</label>
                        <div class="login-input-line">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                            <input type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="login-input-group">
                        <label>Password</label>
                        <div class="login-input-line">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input type="password" name="password" id="passwordField" placeholder="Enter your Password" required>
                            <span class="icon" onclick="togglePassword()" id="eyeIconContainer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="login-options-row">
                        <label class="login-remember">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="login-forgot">Forgot Password ?</a>
                        @endif
                    </div>

                    <button type="submit" class="login-btn-submit">Login</button>
                </form>

                <div class="login-social-area">
                    <p>or continue with</p>
                    <div class="login-social-icons">
                        <svg width="40px" height="40px" viewBox="0 0 16 16">...</svg>
                        <svg width="40px" height="40px" viewBox="-1.5 0 20 20">...</svg>
                        <svg width="40px" height="40px" viewBox="-0.5 0 48 48">...</svg>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const inp = document.getElementById('passwordField');
            const eye = document.getElementById('eyeIconContainer');
            if (inp.type === 'password') {
                inp.type = 'text';
                eye.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>`;
            } else {
                inp.type = 'password';
                eye.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;
            }
        }
    </script>
</body>
</html>