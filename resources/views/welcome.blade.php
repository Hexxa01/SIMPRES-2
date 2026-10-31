<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPRES - Sistem Informasi Manajemen Prestasi Mahasiswa Fakultas Sains dan Teknologi</title>
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --simpres-olive: #5b6743;
            --simpres-olive-dark: #454f32;
            --simpres-olive-light: #7a8a5b;
            --simpres-maroon: #7a1c2c;
            --simpres-maroon-dark: #581420;
            --simpres-gold: #d4a373;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #2b2d42;
            overflow-x: hidden;
        }

        /* Navbar Header (Lap. hal. 100-101) */
        .landing-navbar {
            background-color: var(--simpres-olive);
            padding: 16px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .landing-navbar .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-weight: 800;
            font-size: 22px;
            letter-spacing: 0.5px;
        }

        .landing-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.2s;
        }

        .landing-navbar .nav-link:hover {
            color: #ffffff;
        }

        .btn-login-header {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-login-header:hover {
            background-color: #ffffff;
            color: var(--simpres-olive-dark);
        }

        /* Hero Section */
        .hero-section {
            padding: 70px 0 60px;
            position: relative;
            background: linear-gradient(135deg, #ffffff 60%, #f4f6f0 100%);
        }

        .hero-title {
            font-size: 42px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .hero-subtitle {
            font-size: 20px;
            font-weight: 600;
            color: var(--simpres-olive);
            margin-bottom: 24px;
        }

        .slogan-badge {
            display: inline-block;
            background: linear-gradient(135deg, #5b6743, #434c31);
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 12px;
            margin-bottom: 36px;
            box-shadow: 0 8px 20px rgba(91, 103, 67, 0.25);
            border-left: 5px solid var(--simpres-gold);
        }

        /* Feature Pills (Lap. hal. 100-101: Mudah digunakan, Data Aman, Terintegrasi) */
        .feature-box {
            background: #ffffff;
            border-radius: 14px;
            padding: 16px 18px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s;
        }

        .feature-box:hover {
            transform: translateY(-3px);
        }

        .feature-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(91, 103, 67, 0.12);
            color: var(--simpres-olive);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .campus-visual {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border: 8px solid #ffffff;
        }

        .campus-visual img,
        .campus-visual-svg {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
        }

        /* About Section */
        .section-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .section-tag {
            color: var(--simpres-olive);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 800;
            color: #1e293b;
        }

        /* Footer */
        .landing-footer {
            background-color: #2b2d42;
            color: #ffffff;
            padding: 50px 0 24px;
            border-top: 5px solid var(--simpres-olive);
        }
    </style>
</head>

<body>
    <!-- Header Navbar (Lap. hal. 100-101) -->
    <nav class="navbar navbar-expand-lg landing-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="bg-white rounded-3 p-1 text-success d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-mortarboard-fill fs-4" style="color: var(--simpres-olive);"></i>
                </div>
                <span>SIMPRES</span>
            </a>

            <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>

                <div>
                    <a href="{{ route('pilih-peran') }}" class="btn btn-login-header">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Lap. hal. 100-101) -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1 class="hero-title">Sistem Informasi<br>Manajemen Prestasi Mahasiswa</h1>
                    <div class="hero-subtitle">
                        Fakultas Sains Dan Teknologi<br>UIN Imam Bonjol Padang
                    </div>

                    <!-- Slogan Badge -->
                    <div class="slogan-badge">
                        <i class="bi bi-quote me-2 fs-5"></i> "Mencatat Prestasi, Mengukir Masa Depan"
                    </div>

                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('pilih-peran') }}" class="btn btn-lg px-4 py-3 fw-bold text-white rounded-3 shadow" style="background-color: var(--simpres-olive);">
                            Masuk ke Sistem <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#tentang" class="btn btn-lg btn-outline-secondary px-4 py-3 fw-semibold rounded-3">
                            Pelajari Selengkapnya
                        </a>
                    </div>

                    <!-- 3 Feature Cards (Mudah digunakan, Data Aman, Terintegrasi) -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="feature-box">
                                <div class="feature-icon-wrap">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 13px;">Mudah digunakan</h6>
                                    <small class="text-muted" style="font-size: 11px;">Akses mudah & responsif</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-box">
                                <div class="feature-icon-wrap">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 13px;">Data Aman</h6>
                                    <small class="text-muted" style="font-size: 11px;">Tersimpan terpusat</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-box">
                                <div class="feature-icon-wrap">
                                    <i class="bi bi-diagram-3-fill"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 13px;">Terintegrasi</h6>
                                    <small class="text-muted" style="font-size: 11px;">Mendukung fakultas</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="campus-visual">
                        <!-- Gedung FST UIN Imam Bonjol Representation -->
                        <svg class="campus-visual-svg" viewBox="0 0 600 420" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="skyGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#bfdbfe" />
                                    <stop offset="60%" stop-color="#eff6ff" />
                                    <stop offset="100%" stop-color="#d9f99d" />
                                </linearGradient>
                                <linearGradient id="bldgGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#ffffff" />
                                    <stop offset="100%" stop-color="#f1f5f9" />
                                </linearGradient>
                                <linearGradient id="glassGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8" />
                                    <stop offset="100%" stop-color="#0284c7" />
                                </linearGradient>
                            </defs>
                            <rect width="600" height="420" fill="url(#skyGrad)" />
                            <!-- Mountains in background -->
                            <polygon points="0,320 140,220 280,320" fill="#cbd5e1" opacity="0.6" />
                            <polygon points="200,320 380,180 560,320" fill="#94a3b8" opacity="0.5" />
                            <!-- Campus Building (FST UIN Imam Bonjol) -->
                            <rect x="100" y="140" width="400" height="220" rx="8" fill="url(#bldgGrad)" stroke="#cbd5e1" stroke-width="2" />
                            <rect x="80" y="340" width="440" height="30" fill="#5b6743" rx="4" />
                            <!-- Entrance Pillar & Glass Center -->
                            <rect x="230" y="160" width="140" height="180" fill="url(#glassGrad)" rx="6" />
                            <text x="300" y="130" font-family="'Plus Jakarta Sans', sans-serif" font-weight="bold" font-size="16" fill="#1e293b" text-anchor="middle">FAKULTAS SAINS DAN TEKNOLOGI</text>
                            <text x="300" y="112" font-family="'Plus Jakarta Sans', sans-serif" font-weight="600" font-size="13" fill="#5b6743" text-anchor="middle">UIN IMAM BONJOL PADANG</text>
                            <!-- Windows Grid -->
                            <g fill="#93c5fd" opacity="0.85">
                                <rect x="120" y="170" width="40" height="30" rx="3" />
                                <rect x="175" y="170" width="40" height="30" rx="3" />
                                <rect x="120" y="215" width="40" height="30" rx="3" />
                                <rect x="175" y="215" width="40" height="30" rx="3" />
                                <rect x="120" y="260" width="40" height="30" rx="3" />
                                <rect x="175" y="260" width="40" height="30" rx="3" />

                                <rect x="385" y="170" width="40" height="30" rx="3" />
                                <rect x="440" y="170" width="40" height="30" rx="3" />
                                <rect x="385" y="215" width="40" height="30" rx="3" />
                                <rect x="440" y="215" width="40" height="30" rx="3" />
                                <rect x="385" y="260" width="40" height="30" rx="3" />
                                <rect x="440" y="260" width="40" height="30" rx="3" />
                            </g>
                            <!-- Trees and Garden -->
                            <circle cx="90" cy="340" r="35" fill="#5b6743" />
                            <circle cx="510" cy="340" r="35" fill="#5b6743" />
                            <rect x="0" y="370" width="600" height="50" fill="#4a5435" />
                            <!-- Floating achievement badge -->
                            <g transform="translate(420, 40)">
                                <rect width="160" height="60" rx="12" fill="#ffffff" filter="drop-shadow(0 8px 16px rgba(0,0,0,0.15))" />
                                <circle cx="30" cy="30" r="18" fill="#d4a373" />
                                <text x="30" y="36" font-family="Arial" font-size="18" fill="#fff" text-anchor="middle">🏆</text>
                                <text x="56" y="26" font-family="'Plus Jakarta Sans', sans-serif" font-weight="bold" font-size="13" fill="#1e293b">Prestasi Mahasiswa</text>
                                <text x="56" y="44" font-family="'Plus Jakarta Sans', sans-serif" font-weight="600" font-size="11" fill="#5b6743">FST Terverifikasi</text>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section class="py-5" id="tentang" style="background-color: #f8fafc;">
        <div class="container py-4">
            <div class="section-header">
                <div class="section-tag">Tentang Sistem</div>
                <h2 class="section-title">Solusi Digitalisasi Pendataan Prestasi</h2>
                <p class="text-muted mx-auto" style="max-width: 650px;">
                    Sistem Informasi Manajemen Prestasi Mahasiswa (SIMPRES) FST UIN Imam Bonjol Padang dirancang untuk mempermudah pencatatan, verifikasi, rekapitulasi, dan pemantauan prestasi akademik maupun non-akademik secara terpadu.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm p-4 text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px; background: rgba(91, 103, 67, 0.12); color: var(--simpres-olive);">
                            <i class="bi bi-mortarboard fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bagi Mahasiswa</h5>
                        <p class="text-muted small">
                            Kemudahan dalam mendata prestasi secara terstruktur, mengunggah bukti sertifikat dan foto dokumentasi, serta memantau status verifikasi dan skor prestasi secara transparan.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm p-4 text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px; background: rgba(122, 28, 44, 0.12); color: var(--simpres-maroon);">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bagi Admin</h5>
                        <p class="text-muted small">
                            Memeriksa kelengkapan dokumen pendukung, menentukan status verifikasi, memberikan skor prestasi sesuai ketentuan fakultas, serta memberikan catatan perbaikan secara interaktif.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm p-4 text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px; background: rgba(212, 163, 115, 0.2); color: #9c6c39;">
                            <i class="bi bi-graph-up-arrow fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bagi Pimpinan</h5>
                        <p class="text-muted small">
                            Dashboard analitik statistik dan rekapitulasi data prestasi secara visual (read-only) untuk mendukung evaluasi, pencarian kandidat beasiswa, serta pemantauan kemajuan fakultas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section class="py-5 bg-white" id="kontak">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <div class="section-tag">Kontak & Informasi</div>
                    <h2 class="section-title mb-3">Fakultas Sains dan Teknologi</h2>
                    <p class="text-muted mb-4">
                        Universitas Islam Negeri (UIN) Imam Bonjol Padang<br>
                        Kampus III Sungai Bangek, Lubuk Kilangan, Kota Padang, Sumatera Barat.
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-envelope-fill text-success fs-5"></i>
                            <span>fst@uinib.ac.id</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-telephone-fill text-success fs-5"></i>
                            <span>(0751) 9876543</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-globe text-success fs-5"></i>
                            <span>https://fst.uinib.ac.id</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: linear-gradient(135deg, #5b6743 0%, #4a5435 100%); color: #fff;">
                        <h4 class="fw-bold mb-2">Siap Mencatat Prestasi Anda?</h4>
                        <p class="text-white-50 mb-4">
                            Masuk menggunakan akun SIMPRES Anda sesuai peran (Mahasiswa, Admin, atau Pemimpin Fakultas).
                        </p>
                        <a href="{{ route('pilih-peran') }}" class="btn btn-light fw-bold py-3 px-4 rounded-3 text-dark">
                            Pilih Peran & Masuk <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container text-center">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                <i class="bi bi-mortarboard-fill fs-4 text-warning"></i>
                <span class="fw-bold fs-5">SIMPRES - FST UIN Imam Bonjol Padang</span>
            </div>
            <p class="text-white-50 small mb-0">
                &copy; {{ date('Y') }} Sistem Informasi Manajemen Prestasi Mahasiswa Berbasis Web. All Rights Reserved.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
