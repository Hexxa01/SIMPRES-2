@extends('layout.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid p-0">
    <!-- Greeting Section (Lap. hal. 115-116) -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">
                Dashboard Admin
            </h4>
            <p class="text-muted mb-0 small">Selamat Datang, <strong>{{ auth()->user()->nama ?? auth()->user()->username }}</strong>. Pantau dan kelola data prestasi mahasiswa FST UIN Imam Bonjol.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-olive shadow-sm">
                <i class="bi bi-clipboard-check me-1"></i> Kelola & Verifikasi Data
            </a>
        </div>
    </div>

    <!-- 4 Summary Stat Cards (Lap. hal. 115-116) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon olive">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalPrestasi }}</div>
                    <div class="stat-label">Total Prestasi</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="stat-number text-success">{{ $mahasiswaBerprestasi }}</div>
                    <div class="stat-label">Mahasiswa Berprestasi</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.verifikasi.index', ['status_verifikasi' => 'menunggu']) }}" class="text-decoration-none">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <div class="stat-number text-warning">{{ $dalamProses }}</div>
                        <div class="stat-label">Dalam Proses</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.verifikasi.index', ['status_verifikasi' => 'perlu_perbaikan']) }}" class="text-decoration-none">
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <div class="stat-number text-danger">{{ $perluPerbaikan }}</div>
                        <div class="stat-label">Perlu Perbaikan</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- 2 Donut Charts (Prestasi per Kategori & Status Verifikasi) (Lap. hal. 115-116) -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h5 class="content-card-title">
                        <i class="bi bi-pie-chart-fill" style="color: var(--simpres-olive);"></i> Prestasi per Kategori
                    </h5>
                    <span class="badge bg-light text-muted border">Total: {{ $totalPrestasi }}</span>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-6 text-center position-relative mb-3 mb-sm-0">
                        <div style="width: 200px; height: 200px; margin: 0 auto; position: relative;">
                            <canvas id="chartKategoriAdmin"></canvas>
                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalPrestasi }}</h3>
                                <small class="text-muted" style="font-size: 10px;">Total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="vstack gap-2">
                            @foreach ($kategoriCounts as $kLabel => $info)
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-truncate me-2">{{ $kLabel }}</span>
                                    <span class="fw-bold">{{ $info['count'] }} ({{ $info['pct'] }}%)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h5 class="content-card-title">
                        <i class="bi bi-check-circle-fill text-success"></i> Status Verifikasi
                    </h5>
                    <span class="badge bg-light text-muted border">{{ $totalPrestasi }} Berkas</span>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-6 text-center position-relative mb-3 mb-sm-0">
                        <div style="width: 200px; height: 200px; margin: 0 auto; position: relative;">
                            <canvas id="chartStatusAdmin"></canvas>
                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalPrestasi }}</h3>
                                <small class="text-muted" style="font-size: 10px;">Berkas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="vstack gap-3">
                            @foreach ($statusCounts as $sLabel => $info)
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="fw-semibold">{{ $sLabel }}</span>
                                    <span class="badge rounded-pill px-3 py-1" style="background-color: {{ $info['color'] }}; color: #fff;">
                                        {{ $info['count'] }} ({{ $info['pct'] }}%)
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Menunggu Verifikasi Table -->
    <div class="content-card">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="bi bi-hourglass-split text-warning"></i> Pengajuan Menunggu Verifikasi
            </h5>
            <a href="{{ route('admin.verifikasi.index', ['status_verifikasi' => 'menunggu']) }}" class="btn btn-sm btn-outline-secondary rounded-3">
                Lihat Seluruh Antrean <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-size: 13px;">Mahasiswa</th>
                        <th style="font-size: 13px;">Nama Prestasi</th>
                        <th style="font-size: 13px;">Kategori</th>
                        <th style="font-size: 13px;">Tingkat</th>
                        <th style="font-size: 13px;">Tahun</th>
                        <th style="font-size: 13px;">Diajukan</th>
                        <th class="text-center" style="font-size: 13px;">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menungguTerbaru as $p)
                        <tr>
                            <td>
                                <div class="fw-bold" style="color: #1e293b;">{{ $p->mahasiswa->nama ?? '-' }}</div>
                                <small class="text-muted">NIM: {{ $p->mahasiswa->nim ?? '-' }} | {{ $p->mahasiswa->prodi ?? 'Sains & Teknologi' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-truncate" style="max-width: 250px;">{{ $p->nama_prestasi }}</div>
                                <small class="text-muted">{{ $p->perolehanLabel() }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $p->jenisLabel() }}</span>
                            </td>
                            <td>{{ $p->tingkatLabel() }}</td>
                            <td>{{ $p->tahun_perolehan }}</td>
                            <td class="small text-muted">{{ $p->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.verifikasi.show', $p) }}" class="btn btn-sm btn-olive px-3 rounded-pill fw-semibold shadow-sm">
                                    <i class="bi bi-check2-circle me-1"></i> Periksa & Verifikasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-check2-circle fs-2 text-success d-block mb-1"></i>
                                Semua berkas prestasi sudah selesai diverifikasi. Tidak ada antrean baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart Kategori
        const ctxKategori = document.getElementById('chartKategoriAdmin').getContext('2d');
        const labelsKategori = {!! json_encode(array_keys($kategoriCounts)) !!};
        const dataKategori = {!! json_encode(array_column($kategoriCounts, 'count')) !!};

        new Chart(ctxKategori, {
            type: 'doughnut',
            data: {
                labels: labelsKategori,
                datasets: [{
                    data: dataKategori,
                    backgroundColor: ['#5b6743', '#7a1c2c', '#d4a373', '#2a9d8f', '#e76f51', '#6c757d'],
                    borderWidth: 2,
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Chart Status
        const ctxStatus = document.getElementById('chartStatusAdmin').getContext('2d');
        const labelsStatus = {!! json_encode(array_keys($statusCounts)) !!};
        const dataStatus = {!! json_encode(array_column($statusCounts, 'count')) !!};
        const colorsStatus = {!! json_encode(array_column($statusCounts, 'color')) !!};

        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: labelsStatus,
                datasets: [{
                    data: dataStatus,
                    backgroundColor: colorsStatus,
                    borderWidth: 2,
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endpush
