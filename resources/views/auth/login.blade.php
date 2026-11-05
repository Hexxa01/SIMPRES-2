<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SIMPRES - UIN Imam Bonjol Padang</title>
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --simpres-olive: #5b6743;
            --simpres-olive-dark: #454f32;
            --simpres-maroon: #7a1c2c;
            --simpres-maroon-dark: #581420;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card-container {
            max-width: 980px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
            display: flex;
            min-height: 580px;
        }

        /* Left Side: Brand Banner (Lap. hal. 102-103) */
        .login-left {
            width: 50%;
            background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid #eef2f6;
        }

        .login-left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .brand-badge {
            width: 48px;
            height: 48px;
            background: var(--simpres-olive);
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(91, 103, 67, 0.3);
        }

        .login-left h3 {
            font-weight: 800;
            color: #1e293b;
            font-size: 24px;
            line-height: 1.3;
        }

        .login-left p {
            color: #64748b;
            font-size: 14px;
        }

        .building-illustration {
            width: 100%;
            height: 250px;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Right Side: Form (Lap. hal. 102-103) */
        .login-right {
            width: 50%;
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            font-weight: 800;
            font-size: 26px;
            color: #1e293b;
            margin-bottom: 24px;
            text-align: center;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #cbd5e1;
            padding: 11px 16px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--simpres-olive);
            box-shadow: 0 0 0 3px rgba(91, 103, 67, 0.15);
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .btn-login {
            background-color: var(--simpres-olive);
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            padding: 12px;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: var(--simpres-olive-dark);
            color: #ffffff;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #94a3b8;
            font-size: 13px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 12px;
        }

        .social-btn {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            padding: 9px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 8px;
            transition: all 0.2s;
        }

        .social-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .quick-accounts {
            background: #f8fafc;
            border-radius: 12px;
            padding: 10px 14px;
            margin-top: 18px;
            border: 1px dashed #cbd5e1;
        }

        .quick-account-btn {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #475569;
            cursor: pointer;
            margin-right: 4px;
            margin-bottom: 4px;
        }

        .quick-account-btn:hover {
            background: var(--simpres-olive);
            color: #fff;
            border-color: var(--simpres-olive);
        }

        @media (max-width: 850px) {
            .login-card-container {
                flex-direction: column;
            }
            .login-left, .login-right {
                width: 100%;
            }
            .login-left {
                border-right: none;
                border-bottom: 1px solid #eef2f6;
                padding: 30px;
            }
            .login-right {
                padding: 30px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('simpres-final.css') }}">
</head>

<body>
    <div class="login-card-container">
        <!-- Left Side: Campus Brand Banner (Lap. hal. 102-103) -->
        <div class="login-left">
            <div>
                <div class="login-left-logo">
                    <div class="brand-badge">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0" style="color: var(--simpres-olive);">SIMPRES</h5>
                        <small class="text-muted fw-semibold">UIN Imam Bonjol Padang</small>
                    </div>
                </div>

                <h3>Sistem Informasi<br>Manajemen Prestasi Mahasiswa</h3>
                <p>Fakultas Sains Dan Teknologi Berbasis Web</p>
            </div>

            <!-- Campus Graphic -->
            <div class="building-illustration my-3">
                <svg viewBox="0 0 400 220" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <rect width="400" height="220" fill="#f1f5f9" />
                    <rect x="50" y="70" width="300" height="130" fill="#ffffff" stroke="#cbd5e1" stroke-width="2" rx="4" />
                    <rect x="140" y="80" width="120" height="120" fill="#5b6743" rx="4" />
                    <rect x="160" y="100" width="80" height="100" fill="#38bdf8" rx="2" />
                    <g fill="#94a3b8">
                        <rect x="70" y="90" width="25" height="20" rx="2" />
                        <rect x="105" y="90" width="25" height="20" rx="2" />
                        <rect x="70" y="125" width="25" height="20" rx="2" />
                        <rect x="105" y="125" width="25" height="20" rx="2" />
                        <rect x="70" y="160" width="25" height="20" rx="2" />
                        <rect x="105" y="160" width="25" height="20" rx="2" />

                        <rect x="270" y="90" width="25" height="20" rx="2" />
                        <rect x="305" y="90" width="25" height="20" rx="2" />
                        <rect x="270" y="125" width="25" height="20" rx="2" />
                        <rect x="305" y="125" width="25" height="20" rx="2" />
                        <rect x="270" y="160" width="25" height="20" rx="2" />
                        <rect x="305" y="160" width="25" height="20" rx="2" />
                    </g>
                    <text x="200" y="55" font-family="'Plus Jakarta Sans', sans-serif" font-weight="bold" font-size="12" fill="#5b6743" text-anchor="middle">FAKULTAS SAINS DAN TEKNOLOGI</text>
                    <rect x="0" y="200" width="400" height="20" fill="#4a5435" />
                </svg>
            </div>

            <div class="d-flex align-items-center justify-content-between pt-2">
                <a href="{{ route('pilih-peran') }}" class="text-decoration-none text-muted small fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Pilih Peran Lain
                </a>
                <small class="text-muted">&copy; 2026 SIMPRES</small>
            </div>
        </div>

        <!-- Right Side: Login Form (Lap. hal. 102-103) -->
        <div class="login-right">
            <h2 class="login-title">Selamat Datang</h2>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 rounded-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <!-- Dropdown DAFTAR SEBAGAI (Lap. hal. 102-103) -->
                <div class="mb-3">
                    <label class="form-label" for="roleSelect">DAFTAR SEBAGAI</label>
                    <select name="role" id="roleSelect" class="form-select" required>
                        <option value="mahasiswa" @selected(old('role', request('role')) === 'mahasiswa')>Mahasiswa</option>
                        <option value="admin" @selected(old('role', request('role')) === 'admin')>Admin</option>
                        <option value="pimpinan" @selected(old('role', request('role')) === 'pimpinan')>Pemimpin (Pimpinan Fakultas / Dekan)</option>
                    </select>
                </div>

                <!-- Input Email/NIM/NIP -->
                <div class="mb-3">
                    <label class="form-label" for="loginInput">Email/NIM/NIP</label>
                    <input type="text" name="login" id="loginInput" class="form-control" placeholder="Masukkan Email / NIM / NIP" value="{{ old('login') }}" required autofocus>
                </div>

                <!-- Input Kata Sandi -->
                <div class="mb-3">
                    <label class="form-label" for="passwordInput">Kata Sandi</label>
                    <div class="position-relative">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan Kata Sandi" required>
                        <i class="bi bi-eye password-toggle" id="togglePasswordBtn" onclick="togglePasswordVisibility()"></i>
                    </div>
                </div>

                <!-- Ingat Saya & Lupa Kata Sandi -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberCheck" @checked(old('remember'))>
                        <label class="form-check-label small text-muted" for="rememberCheck">
                            Ingat Saya
                        </label>
                    </div>
                    <a href="javascript:void(0)" onclick="alert('Silakan hubungi Administrator SIMPRES untuk mereset kata sandi akun Anda.')" class="text-decoration-none small text-muted">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit" class="btn btn-login shadow-sm">
                    LOGIN
                </button>
            </form>

            <div class="divider">
                <span>Atau</span>
            </div>

            <!-- Alternatif Login (Google & Microsoft) (Lap. hal. 102-103) -->
            <button type="button" class="social-btn" onclick="alert('Integrasi SSO Google Kampus akan segera aktif.')">
                <i class="bi bi-google text-danger"></i> Login Dengan Google
            </button>
            <button type="button" class="social-btn" onclick="alert('Integrasi SSO Microsoft Office 365 akan segera aktif.')">
                <i class="bi bi-microsoft text-primary"></i> Login Dengan Microsoft
            </button>

            <!-- Belum memiliki akun? Hubungi Admin -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    Belum Memiliki akun?
                    <a href="javascript:void(0)" onclick="alert('Pendaftaran akun mahasiswa baru dilakukan oleh pihak Akademik/Admin FST UIN Imam Bonjol.')" class="fw-semibold text-decoration-none" style="color: var(--simpres-olive);">
                        Hubungi Admin
                    </a>
                </small>
            </div>

            <!-- Quick Account Fill for Evaluation -->
            <div class="quick-accounts">
                <div class="small fw-bold text-muted mb-1" style="font-size: 11px;">Akun Cepat (Sesuai Laporan Proyek):</div>
                <div class="d-flex flex-wrap">
                    <button type="button" class="quick-account-btn" onclick="isiAkun('mahasiswa01', 'Mhs12345', 'mahasiswa')">
                        🎓 Mahasiswa (Alya putri)
                    </button>
                    <button type="button" class="quick-account-btn" onclick="isiAkun('admin01', 'Admin12345', 'admin')">
                        ⚙️ Admin (Aura Maylia)
                    </button>
                    <button type="button" class="quick-account-btn" onclick="isiAkun('pimpinan01', 'Pimpinan12345', 'pimpinan')">
                        🏛️ Pemimpin (Selvia)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('passwordInput');
            const icon = document.getElementById('togglePasswordBtn');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        function isiAkun(login, password, role) {
            document.getElementById('roleSelect').value = role;
            document.getElementById('loginInput').value = login;
            document.getElementById('passwordInput').value = password;
        }
    </script>
</body>

</html>
