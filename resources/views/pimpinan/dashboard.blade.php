@extends('layout.app')

@section('title', 'Dashboard Pimpinan')

@section('content')
    <!-- Header Selamat Datang Pimpinan -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-warning text-dark px-2 py-1 rounded-pill fw-semibold" style="font-size: 11px;">
                    <i class="bi bi-shield-check"></i> Pemimpin Fakultas
                </span>
                <span class="text-muted small">Fakultas Sains dan Teknologi</span>
            </div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--simpres-olive-dark);">
                Selamat Datang, {{ auth()->user()->nama ?? 'Pimpinan Fakultas' }}
            </h1>
            <p class="text-muted mb-0">Ringkasan capaian dan visualisasi prestasi mahasiswa FST UIN Imam Bonjol Padang</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pimpinan.rekapitulasi') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-pie-chart"></i>
                <span>Lihat Rekapitulasi</span>
            </a>
            <a href="{{ route('pimpinan.prestasi.index') }}" class="btn btn-olive d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Data Prestasi</span>
            </a>
        </div>
    </div>

    <!-- 4 Stat Cards Utama (Lap. hal. 127) -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon stat-olive">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalPrestasi }}</div>
                    <div class="stat-label">Total Prestasi Tercatat</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon stat-gold">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $mahasiswaBerprestasi }}</div>
                    <div class="stat-label">Mahasiswa Berprestasi</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon stat-maroon">
                    <i class="bi bi-folder-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $kategoriCount }}</div>
                    <div class="stat-label">Kategori Prestasi</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon stat-blue">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $terverifikasi }}</div>
                    <div class="stat-label">Prestasi Terverifikasi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Visualisasi / Grafik Utama (Lap. hal. 127-128) -->
    <div class="row g-4 mb-4">
        <!-- 1. Horizontal Bar Chart: Kategori Prestasi -->
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h2 class="content-card-title">
                        <i class="bi bi-bar-chart-steps text-success"></i>
                        Kategori Prestasi
                    </h2>
                    <span class="badge bg-light text-dark border">Bidang Capaian</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="chartKategoriPimpinan"></canvas>
                </div>
            </div>
        </div>

        <!-- 2. Donut Chart: Tingkat Prestasi -->
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h2 class="content-card-title">
                        <i class="bi bi-pie-chart text-warning"></i>
                        Tingkat Prestasi
                    </h2>
                    <span class="badge bg-light text-dark border">Cakupan Wilayah</span>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-6 text-center">
                        <div style="max-height: 230px; position: relative;">
                            <canvas id="chartTingkatPimpinan"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3 mt-sm-0">
                        <ul class="list-group list-group-flush small">
                            @foreach ($tingkatData as $label => $val)
                                @php
                                    $pct = $totalPrestasi > 0 ? round(($val / $totalPrestasi) * 100, 1) : 0;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                    <span class="text-truncate me-2">{{ $label }}</span>
                                    <span class="fw-bold">{{ $val }} <span class="text-muted fw-normal">({{ $pct }}%)</span></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Vertical Bar Chart: Tren Prestasi per Tahun -->
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h2 class="content-card-title">
                        <i class="bi bi-graph-up-arrow text-primary"></i>
                        Tren Prestasi per Tahun
                    </h2>
                    <span class="badge bg-light text-dark border">Perkembangan Tahunan</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="chartTahunPimpinan"></canvas>
                </div>
            </div>
        </div>

        <!-- 4. Bar Chart: Prestasi per Program Studi -->
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h2 class="content-card-title">
                        <i class="bi bi-mortarboard text-danger"></i>
                        Prestasi per Program Studi
                    </h2>
                    <span class="badge bg-light text-dark border">Sebaran Jurusan</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="chartProdiPimpinan"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, rgba(91, 103, 67, 0.08) 0%, rgba(122, 28, 44, 0.08) 100%);">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle p-3 bg-white text-olive shadow-sm">
                    <i class="bi bi-info-circle-fill fs-3" style="color: var(--simpres-olive);"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Akses Pemimpin Fakultas (Read-Only)</h5>
                    <p class="text-muted small mb-0">
                        Anda dapat memantau capaian mahasiswa secara menyeluruh, melihat rekapitulasi data, serta mengunduh laporan format Excel untuk kebutuhan akreditasi & pelaporan fakultas.
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pimpinan.rekapitulasi') }}" class="btn btn-olive">
                    <i class="bi bi-table me-1"></i> Buka Rekapitulasi
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // 1. Horizontal Bar: Kategori Prestasi
                const ctxKat = document.getElementById('chartKategoriPimpinan');
                if (ctxKat) {
                    new Chart(ctxKat, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode(array_keys($kategoriData)) !!},
                            datasets: [{
                                label: 'Jumlah Prestasi',
                                data: {!! json_encode(array_values($kategoriData)) !!},
                                backgroundColor: '#5b6743',
                                borderRadius: 6
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }

                // 2. Donut Chart: Tingkat Prestasi
                const ctxTingkat = document.getElementById('chartTingkatPimpinan');
                if (ctxTingkat) {
                    new Chart(ctxTingkat, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode(array_keys($tingkatData)) !!},
                            datasets: [{
                                data: {!! json_encode(array_values($tingkatData)) !!},
                                backgroundColor: [
                                    '#5b6743',
                                    '#7a1c2c',
                                    '#cfa83c',
                                    '#2a6f97',
                                    '#8d99ae',
                                    '#6b705c',
                                    '#d4a373'
                                ],
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            cutout: '65%'
                        }
                    });
                }

                // 3. Vertical Bar: Tren Tahun
                const ctxTahun = document.getElementById('chartTahunPimpinan');
                if (ctxTahun) {
                    new Chart(ctxTahun, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode(array_keys($tahunData)) !!},
                            datasets: [{
                                label: 'Jumlah Prestasi',
                                data: {!! json_encode(array_values($tahunData)) !!},
                                backgroundColor: '#2a6f97',
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }

                // 4. Bar Chart: Prodi
                const ctxProdi = document.getElementById('chartProdiPimpinan');
                if (ctxProdi) {
                    new Chart(ctxProdi, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode(array_keys($prodiData)) !!},
                            datasets: [{
                                label: 'Prestasi',
                                data: {!! json_encode(array_values($prodiData)) !!},
                                backgroundColor: '#7a1c2c',
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
