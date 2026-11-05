<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Peran Anda | SIMPRES - UIN Imam Bonjol Padang</title>
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
            padding: 20px;
        }

        .role-wrapper {
            max-width: 960px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
            display: flex;
            min-height: 560px;
        }

        /* Left Side: Campus Brand Banner (Lap. hal. 101-102) */
        .role-left {
            width: 50%;
            background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 1px solid #eef2f6;
        }

        .role-left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
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

        .role-left h3 {
            font-weight: 800;
            color: #1e293b;
            font-size: 24px;
            line-height: 1.3;
        }

        .role-left p {
            color: #64748b;
            font-size: 14px;
        }

        /* Building graphic illustration */
        .building-illustration {
            width: 100%;
            height: 240px;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Right Side: Role Selection Cards */
        .role-right {
            width: 50%;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .role-right-title {
            font-weight: 800;
            font-size: 26px;
            color: #1e293b;
            margin-bottom: 8px;
            text-align: center;
        }

        .role-right-subtitle {
            color: #64748b;
            font-size: 14px;
            text-align: center;
            margin-bottom: 32px;
        }

        .role-card-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            margin-bottom: 16px;
            text-decoration: none;
            color: #1e293b;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .role-card-item:hover {
            border-color: var(--simpres-olive);
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(91, 103, 67, 0.12);
            color: var(--simpres-olive-dark);
        }

        .role-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--simpres-olive);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.2s;
        }

        .role-card-item:hover .role-icon-box {
            background: var(--simpres-olive);
            color: #ffffff;
            border-color: var(--simpres-olive);
        }

        .role-card-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .role-card-desc {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        @media (max-width: 850px) {
            .role-wrapper {
                flex-direction: column;
            }
            .role-left, .role-right {
                width: 100%;
            }
            .role-left {
                border-right: none;
                border-bottom: 1px solid #eef2f6;
                padding: 30px;
            }
            .role-right {
                padding: 30px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('simpres-final.css') }}">
</head>

<body>
    <div class="role-wrapper">
        <!-- Left Side (Lap. hal. 101-102) -->
        <div class="role-left">
            <div>
                <div class="role-left-logo">
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
                    <!-- Stylized FST Building -->
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
                <a href="{{ url('/') }}" class="text-decoration-none text-muted small fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
                <small class="text-muted">&copy; 2026 SIMPRES</small>
            </div>
        </div>

        <!-- Right Side: Pilih Peran Anda (Lap. hal. 101-102) -->
        <div class="role-right">
            <h2 class="role-right-title">Pilih Peran Anda</h2>
            <p class="role-right-subtitle">Silakan pilih jenis akun yang sesuai untuk melanjutkan ke halaman login</p>

            <!-- 1. Mahasiswa -->
            <a href="{{ route('login', ['role' => 'mahasiswa']) }}" class="role-card-item">
                <div class="role-icon-box">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="role-card-title">Mahasiswa</div>
                    <p class="role-card-desc">Kelola dan laporkan prestasi yang Anda raih selama perkuliahan</p>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </a>

            <!-- 2. Admin -->
            <a href="{{ route('login', ['role' => 'admin']) }}" class="role-card-item">
                <div class="role-icon-box">
                    <i class="bi bi-person-gear"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="role-card-title">Admin</div>
                    <p class="role-card-desc">Verifikasi berkas sertifikat, berikan skor & kelola data prestasi</p>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </a>

            <!-- 3. Pemimpin (Pimpinan Fakultas / Dekan) -->
            <a href="{{ route('login', ['role' => 'pimpinan']) }}" class="role-card-item">
                <div class="role-icon-box">
                    <i class="bi bi-award-fill"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="role-card-title">Pemimpin</div>
                    <p class="role-card-desc">Pantau dashboard statistik dan rekapitulasi data prestasi fakultas</p>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
