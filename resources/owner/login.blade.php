<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kelolain</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f0ee;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 4px 40px rgba(0,0,0,0.12);
            min-height: 520px;
        }

        /* LEFT PANEL */
        .login-left {
            flex: 1;
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .logo-text span { color: #e8a020; }

        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            width: 16px;
            height: 16px;
        }

        .input-wrap input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1a1a1a;
            background: #fafafa;
            transition: border-color 0.2s;
            outline: none;
        }

        .input-wrap input:focus {
            border-color: #2d6a4f;
            background: #fff;
        }

        .input-wrap input::placeholder { color: #bbb; }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #aaa;
            padding: 0;
            display: flex;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 4px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #666;
            cursor: pointer;
        }

        .remember input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: #2d6a4f;
        }

        .forgot {
            font-size: 13px;
            color: #2d6a4f;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot:hover { text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #2d6a4f;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover { background: #245a42; }
        .btn-login:active { transform: scale(0.99); }

        .btn-login:disabled {
            background: #a0c4b4;
            cursor: not-allowed;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #888;
        }

        .register-link a {
            color: #2d6a4f;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover { text-decoration: underline; }

        .alert-error {
            background: #fff0f0;
            border: 1px solid #ffc5c5;
            color: #cc3333;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            display: none;
        }

        .alert-error.show { display: block; }

        /* RIGHT PANEL */
        .login-right {
            width: 380px;
            background: #2d6a4f;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-right::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 240px;
            height: 240px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .login-right::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .right-img {
            width: 100%;
            max-width: 280px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
        }

        .right-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            line-height: 1.3;
        }

        .right-desc {
            font-size: 13px;
            color: rgba(255,255,255,0.75);
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* Loading spinner */
        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 640px) {
            .login-right { display: none; }
            .login-left { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- LEFT -->
    <div class="login-left">
        <div class="logo">
            <svg class="logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="8" fill="#f0f7f4"/>
                <path d="M12 8h5v14l8-8h6L20 26l12 14h-6.5L12 26V8z" fill="#2d6a4f"/>
                <ellipse cx="24" cy="28" rx="6" ry="3" fill="#e8a020" opacity="0.9"/>
            </svg>
            <span class="logo-text">KL<span>o</span>lain</span>
        </div>

        <h1>Selamat Datang</h1>

        <div class="alert-error" id="alertError"></div>

        <form id="loginForm">
            <div class="form-group">
                <label>Email atau Username</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input type="text" id="login" placeholder="user@gmail.com" required autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input type="password" id="password" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <label class="remember">
                    <input type="checkbox" id="remember"> Ingat saya
                </label>
                <a href="#" class="forgot">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <span id="btnText">Masuk →</span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>

        <p class="register-link">
            Belum punya akun? <a href="#">Daftar sekarang</a>
        </p>
    </div>

    <!-- RIGHT -->
    <div class="login-right">
        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=560&q=80"
             alt="Dashboard Preview" class="right-img">
        <p class="right-title">Visualisasikan Pertumbuhan Bisnis Anda</p>
        <p class="right-desc">Dari manajemen transaksi harian hingga laporan keuangan komprehensif, semuanya dalam satu dasbor terpadu.</p>
    </div>
</div>

<script>
    const API_BASE = '/api';

    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function showError(msg) {
        const el = document.getElementById('alertError');
        el.textContent = msg;
        el.classList.add('show');
    }

    function hideError() {
        document.getElementById('alertError').classList.remove('show');
    }

    function setLoading(loading) {
        const btn = document.getElementById('btnLogin');
        const text = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');
        btn.disabled = loading;
        text.style.display = loading ? 'none' : 'inline';
        spinner.style.display = loading ? 'block' : 'none';
    }

    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        hideError();
        setLoading(true);

        const login    = document.getElementById('login').value.trim();
        const password = document.getElementById('password').value;

        try {
            const response = await fetch(`${API_BASE}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ login, password })
            });

            const data = await response.json();

            if (data.status && data.data.token) {
                // Simpan token & user ke localStorage
                localStorage.setItem('token', data.data.token);
                localStorage.setItem('user', JSON.stringify(data.data.user));

                // Cek role — redirect sesuai role
                if (data.data.user.role === 'owner') {
                    window.location.href = '/owner/dashboard';
                } else {
                    window.location.href = '/dashboard';
                }
            } else {
                showError(data.message || 'Login gagal. Periksa kembali email dan password.');
            }
        } catch (err) {
            showError('Koneksi ke server gagal. Pastikan server berjalan.');
        } finally {
            setLoading(false);
        }
    });

    // Cek jika sudah login
    const token = localStorage.getItem('token');
    const user  = token ? JSON.parse(localStorage.getItem('user') || '{}') : null;
    if (token && user) {
        window.location.href = user.role === 'owner' ? '/owner/dashboard' : '/dashboard';
    }
</script>

</body>
</html>
