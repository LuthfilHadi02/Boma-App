<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BOMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
                    @csrf @if ($errors->any())
                        <div style="color: #FF4B4B; margin-bottom: 15px; font-size: 14px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="login-input-group">
                        <label>Email</label>
                        <div class="login-input-line">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx=""/></svg>
                            <input type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="login-input-group">
                        <label>Password</label>
                        <div class="login-input-line">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input type="password" name="password" id="passwordField" placeholder="Enter your Password" required>
                            <span class="icon" onclick="togglePassword()" style="cursor: pointer; display: flex; align-items: center;" id="eyeIconContainer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
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
            const passwordInput = document.getElementById('passwordField');
            const eyeContainer = document.getElementById('eyeIconContainer');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>`;
            } else {
                passwordInput.type = 'password';
                eyeContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>`;
            }
        }
    </script>
</body>
</html>