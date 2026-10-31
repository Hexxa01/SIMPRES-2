<div class="row g-4">
    <!-- Left Column: Certificate Preview & Mahasiswa Info (Lap. hal. 120) -->
    <div class="col-lg-5">
        <!-- Certificate Preview Card -->
        <div class="content-card mb-4 text-center">
            <div class="content-card-header text-start">
                <h5 class="content-card-title">
                    <i class="bi bi-award-fill text-warning"></i> Sertifikat Prestasi
                </h5>
                @if ($prestasi->sertifikat->isNotEmpty())
                    <a href="{{ route('berkas.sertifikat', $prestasi->sertifikat->first()) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Penuh
                    </a>
                @endif
            </div>

            @if ($prestasi->sertifikat->isNotEmpty())
                @php
                    $s = $prestasi->sertifikat->first();
                    $isImg = in_array(strtolower(pathinfo($s->nama_file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']);
                @endphp
                <div class="p-3 bg-light rounded-4 border">
                    @if($isImg)
                        <img src="{{ route('berkas.sertifikat', $s) }}" alt="{{ $s->nama_file }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 280px; object-fit: contain;">
                    @else
                        <div class="py-5 text-center">
                            <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 64px;"></i>
                            <h6 class="fw-bold mt-2 text-dark">{{ $s->nama_file }}</h6>
                            <p class="text-muted small">Dokumen Sertifikat Resmi</p>
                            <a href="{{ route('berkas.sertifikat', $s) }}" target="_blank" class="btn btn-sm btn-olive">
                                <i class="bi bi-eye me-1"></i> Lihat Dokumen Sertifikat
                            </a>
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                    <small class="text-muted text-truncate" style="max-width: 200px;">{{ $s->nama_file }}</small>
                    <small class="text-muted">Diunggah: {{ $s->tgl_upload ? $s->tgl_upload->format('d/m/Y') : '-' }}</small>
                </div>
            @else
                <div class="py-4 text-muted">
                    <i class="bi bi-file-earmark-x fs-1 text-secondary"></i>
                    <p class="small mb-0 mt-2">Belum ada file sertifikat.</p>
                </div>
            @endif
        </div>

        <!-- Data Mahasiswa Card -->
        <div class="content-card mb-4">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-person-badge" style="color: var(--simpres-olive);"></i> Data Mahasiswa
                </h5>
            </div>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 50px; height: 50px; background-color: var(--simpres-olive);">
                    {{ strtoupper(substr($prestasi->mahasiswa->nama ?? 'M', 0, 1)) }}
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">{{ $prestasi->mahasiswa->nama ?? '-' }}</h6>
                    <small class="text-muted">NIM: {{ $prestasi->mahasiswa->nim ?? '-' }}</small>
                </div>
            </div>
            <dl class="row small mb-0">
                <dt class="col-5 text-muted">Program Studi</dt>
                <dd class="col-7 fw-semibold">{{ $prestasi->mahasiswa->prodi ?? 'Sistem Informasi' }}</dd>
                <dt class="col-5 text-muted">Fakultas</dt>
                <dd class="col-7 fw-semibold">{{ $prestasi->mahasiswa->fakultas ?? 'Fakultas Sains dan Teknologi' }}</dd>
                <dt class="col-5 text-muted">Angkatan</dt>
                <dd class="col-7 fw-semibold">{{ $prestasi->mahasiswa->angkatan ?? '2024' }}</dd>
            </dl>
        </div>

        <!-- Dokumentasi Pendukung Card -->
        <div class="content-card">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-images text-primary"></i> Dokumentasi Pendukung
                </h5>
                <span class="badge bg-light text-muted border">{{ $prestasi->dokumentasi->count() }} foto</span>
            </div>

            @if ($prestasi->dokumentasi->isEmpty())
                <p class="text-muted small mb-0 text-center py-3">Tidak ada foto dokumentasi tambahan.</p>
            @else
                <div class="row g-2">
                    @foreach ($prestasi->dokumentasi as $d)
                        <div class="col-6">
                            <a href="{{ route('berkas.dokumentasi', $d) }}" target="_blank" class="d-block text-decoration-none">
                                <img src="{{ route('berkas.dokumentasi', $d) }}" alt="{{ $d->nama_file }}"
                                    class="rounded-3 w-100 shadow-sm border" style="height:110px; object-fit:cover;" loading="lazy">
                                <small class="text-muted text-truncate d-block mt-1" style="font-size: 11px;">
                                    {{ $d->keterangan ?: $d->nama_file }}
                                </small>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Achievement Details & Status (Lap. hal. 120) -->
    <div class="col-lg-7">
        <div class="content-card mb-4">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-info-circle-fill" style="color: var(--simpres-olive);"></i> Detail Informasi Prestasi
                </h5>
            </div>

            <dl class="row mb-0 gy-3">
                <dt class="col-sm-4 text-muted small">Nama Prestasi</dt>
                <dd class="col-sm-8 fw-bold fs-6 text-dark">{{ $prestasi->nama_prestasi }}</dd>

                <dt class="col-sm-4 text-muted small">Kategori Prestasi</dt>
                <dd class="col-sm-8">
                    <span class="badge bg-light text-dark border px-3 py-1">
                        {{ $prestasi->jenisLabel() }}
                    </span>
                </dd>

                <dt class="col-sm-4 text-muted small">Tingkat Prestasi</dt>
                <dd class="col-sm-8 fw-semibold">{{ $prestasi->tingkatLabel() }}</dd>

                <dt class="col-sm-4 text-muted small">Peringkat / Perolehan</dt>
                <dd class="col-sm-8">
                    <span class="badge bg-success-subtle text-success px-3 py-1 fw-bold">
                        <i class="bi bi-trophy-fill me-1"></i> {{ $prestasi->perolehanLabel() }}
                    </span>
                </dd>

                <dt class="col-sm-4 text-muted small">Tahun Perolehan</dt>
                <dd class="col-sm-8 fw-semibold">{{ $prestasi->tahun_perolehan }}</dd>

                <dt class="col-sm-4 text-muted small">Tahun Penyelenggaraan</dt>
                <dd class="col-sm-8 fw-semibold">{{ $prestasi->tahun_penyelenggaraan ?? $prestasi->tahun_perolehan }}</dd>

                <dt class="col-sm-4 text-muted small">Pihak Penyelenggara</dt>
                <dd class="col-sm-8 fw-semibold">{{ $prestasi->penyelenggara }}</dd>

                <dt class="col-sm-4 text-muted small">Tempat / Lokasi</dt>
                <dd class="col-sm-8">{{ $prestasi->tempat_pelaksanaan ?: '-' }}</dd>

                <dt class="col-sm-4 text-muted small">Informasi Pendukung</dt>
                <dd class="col-sm-8 text-secondary">{!! nl2br(e($prestasi->deskripsi ?: '-')) !!}</dd>
            </dl>
        </div>

        <!-- Status Verifikasi & Hasil Penilaian (Lap. hal. 119-122) -->
        <div class="content-card mb-4 border-start border-4 @if($prestasi->status_verifikasi === 'terverifikasi') border-success @elseif($prestasi->status_verifikasi === 'perlu_perbaikan') border-danger @else border-warning @endif">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-shield-check" style="color: var(--simpres-olive);"></i> Status Verifikasi & Hasil Pemeriksaan
                </h5>
            </div>

            <dl class="row mb-0 gy-3">
                <dt class="col-sm-4 text-muted small">Status Data</dt>
                <dd class="col-sm-8">
                    @include('partials.status-badge', ['prestasi' => $prestasi])
                </dd>

                <dt class="col-sm-4 text-muted small">Skor Prestasi</dt>
                <dd class="col-sm-8">
                    @if($prestasi->skor !== null)
                        <span class="fs-4 fw-bold text-success">{{ $prestasi->skorTampil() }}</span>
                        <span class="text-muted small">/ 100</span>
                    @else
                        <span class="text-muted small">Belum dinilai oleh Admin</span>
                    @endif
                </dd>

                <dt class="col-sm-4 text-muted small">Verifikator</dt>
                <dd class="col-sm-8 small">
                    {{ $prestasi->verifikator->nama ?? 'Belum diverifikasi' }}
                    @if ($prestasi->diverifikasi_pada)
                        <span class="text-muted">({{ $prestasi->diverifikasi_pada->format('d/m/Y H:i') }})</span>
                    @endif
                </dd>

                <dt class="col-sm-4 text-muted small">Catatan Pemeriksaan</dt>
                <dd class="col-sm-8">
                    @if($prestasi->catatan_revisi)
                        <div class="p-3 bg-light rounded-3 text-dark small border">
                            {{ $prestasi->catatan_revisi }}
                        </div>
                    @else
                        <span class="text-muted small">Tidak ada catatan perbaikan.</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
</div>
