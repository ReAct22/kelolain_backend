<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kelolain</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-wrapper">
        <!-- LEFT -->
        <div class="login-left">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Kelolain Logo">
                <span class="logo-text">KL<span>o</span>lain</span>
            </div>

            <h1>Selamat Datang</h1>

            <div class="alert-error" id="alertError"></div>

            <form id="loginForm">
                <div class="form-group">
                    <label>Email atau Username</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <input type="text" id="login" placeholder="user@gmail.com" required
                            autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <input type="password" id="password" placeholder="••••••••" required
                            autocomplete="current-password">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" width="16" height="16">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
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
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=560&q=80" alt="Dashboard Preview"
                class="right-img">
            <p class="right-title">Visualisasikan Pertumbuhan Bisnis Anda</p>
            <p class="right-desc">Dari manajemen transaksi harian hingga laporan keuangan komprehensif, semuanya dalam
                satu dasbor terpadu.</p>
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

            const login = document.getElementById('login').value.trim();
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(`${API_BASE}/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        login,
                        password
                    })
                });

                const data = await response.json();

                if (data.status && data.data.token) {
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));

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
        const user = token ? JSON.parse(localStorage.getItem('user') || '{}') : null;
        if (token && user && user.role) {
            window.location.href = user.role === 'owner' ? '/owner/dashboard' : '/dashboard';
        }
    </script>

</body>

</html>
