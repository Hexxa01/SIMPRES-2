@php
    $p = $prestasi ?? null;
    $dokLama = $p ? $p->dokumentasi : collect();
    $sisaSlot = max(0, 10 - $dokLama->count());
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <!-- Catatan Revisi Admin (Jika Ada / Mode Perbaikan) -->
    @if ($p && $p->catatan_revisi)
        <div class="alert alert-warning border-0 rounded-4 p-4 mb-4 shadow-sm" style="background-color: #fff3cd;">
            <div class="d-flex align-items-center gap-2 mb-2 text-warning-emphasis">
                <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
                <h6 class="fw-bold mb-0">Catatan Perbaikan dari Admin:</h6>
            </div>
            <p class="mb-0 text-dark ps-4">{{ $p->catatan_revisi }}</p>
        </div>
    @endif

    <!-- 1. Halaman Input Data Prestasi (Lap. hal. 106-107) -->
    <div class="content-card mb-4" id="section-data-prestasi">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="bi bi-card-text" style="color: var(--simpres-olive);"></i> Informasi Data Prestasi
            </h5>
            <span class="badge bg-light text-dark border">Langkah 1</span>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <label for="nama_prestasi" class="form-label small fw-bold">Nama Prestasi / Kegiatan <span class="text-danger">*</span></label>
                <input type="text" id="nama_prestasi" name="nama_prestasi" maxlength="200"
                    value="{{ old('nama_prestasi', $p->nama_prestasi ?? '') }}"
                    class="form-control @error('nama_prestasi') is-invalid @enderror"
                    placeholder="Contoh: Lomba Desain UI/UX Mahasiswa Nasional" required>
            </div>

            <div class="col-md-4">
                <label for="jenis_prestasi" class="form-label small fw-bold">Jenis / Kategori Prestasi <span class="text-danger">*</span></label>
                <select id="jenis_prestasi" name="jenis_prestasi"
                    class="form-select @error('jenis_prestasi') is-invalid @enderror" required>
                    <option value="">- Pilih Kategori -</option>
                    @foreach (\App\Models\Prestasi::JENIS as $k => $label)
                        <option value="{{ $k }}" @selected(old('jenis_prestasi', $p->jenis_prestasi ?? '') === $k)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="tingkat_prestasi" class="form-label small fw-bold">Tingkat Prestasi <span class="text-danger">*</span></label>
                <select id="tingkat_prestasi" name="tingkat_prestasi"
                    class="form-select @error('tingkat_prestasi') is-invalid @enderror" required>
                    <option value="">- Pilih Tingkat -</option>
                    @foreach (\App\Models\Prestasi::TINGKAT as $k => $label)
                        <option value="{{ $k }}" @selected(old('tingkat_prestasi', $p->tingkat_prestasi ?? '') === $k)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="tahun_perolehan" class="form-label small fw-bold">Tahun Perolehan <span class="text-danger">*</span></label>
                <input type="number" id="tahun_perolehan" name="tahun_perolehan" min="1900" max="{{ now()->year }}"
                    value="{{ old('tahun_perolehan', $p->tahun_perolehan ?? date('Y')) }}"
                    class="form-control @error('tahun_perolehan') is-invalid @enderror" required>
            </div>

            <div class="col-md-4">
                <label for="tahun_penyelenggaraan" class="form-label small fw-bold">Tahun Penyelenggaraan</label>
                <input type="number" id="tahun_penyelenggaraan" name="tahun_penyelenggaraan" min="1900" max="{{ now()->year + 1 }}"
                    value="{{ old('tahun_penyelenggaraan', $p->tahun_penyelenggaraan ?? date('Y')) }}"
                    class="form-control @error('tahun_penyelenggaraan') is-invalid @enderror">
            </div>

            <div class="col-md-6">
                <label for="penyelenggara" class="form-label small fw-bold">Pihak Penyelenggara <span class="text-danger">*</span></label>
                <input type="text" id="penyelenggara" name="penyelenggara" maxlength="200"
                    value="{{ old('penyelenggara', $p->penyelenggara ?? '') }}"
                    class="form-control @error('penyelenggara') is-invalid @enderror"
                    placeholder="Contoh: Universitas Islam Negeri Imam Bonjol Padang / Kemendikbud" required>
            </div>

            <div class="col-md-6">
                <label for="tempat_pelaksanaan" class="form-label small fw-bold">Tempat Pelaksanaan / Lokasi</label>
                <input type="text" id="tempat_pelaksanaan" name="tempat_pelaksanaan" maxlength="200"
                    value="{{ old('tempat_pelaksanaan', $p->tempat_pelaksanaan ?? '') }}"
                    class="form-control @error('tempat_pelaksanaan') is-invalid @enderror"
                    placeholder="Contoh: Padang / Jakarta / Daring (Zoom)">
            </div>

            <div class="col-12">
                <label for="deskripsi" class="form-label small fw-bold">Deskripsi / Informasi Pendukung</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="3000"
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    placeholder="Tuliskan keterangan tambahan mengenai prestasi, jumlah tim delegasi, lingkup kompetisi, dll">{{ old('deskripsi', $p->deskripsi ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- 2. Halaman Upload Sertifikat Mahasiswa (Lap. hal. 107-108) -->
    <div class="content-card mb-4" id="section-upload-sertifikat">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="bi bi-file-earmark-check-fill text-success"></i> Upload Sertifikat / Bukti Prestasi
            </h5>
            <span class="badge bg-light text-dark border">Langkah 2</span>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <label class="form-label small fw-bold">
                    File Sertifikat
                    @unless ($p)
                        <span class="text-danger">*</span>
                    @endunless
                </label>

                @if ($p && $p->sertifikat->isNotEmpty())
                    <div class="p-2 mb-2 bg-light rounded-3 d-flex align-items-center justify-content-between">
                        <span class="small text-truncate">
                            <i class="bi bi-file-earmark-pdf text-danger me-1"></i> {{ $p->sertifikat->first()->nama_file }}
                        </span>
                        <a href="{{ route('berkas.sertifikat', $p->sertifikat->first()) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11px;">
                            Lihat File
                        </a>
                    </div>
                @endif

                <div class="p-4 border-2 border-dashed rounded-4 text-center bg-light" style="border: 2px dashed #cbd5e1;">
                    <i class="bi bi-cloud-arrow-up-fill fs-1 text-secondary"></i>
                    <p class="small text-muted mb-2">Pilih file sertifikat bukti prestasi dari perangkat Anda</p>
                    <input type="file" id="sertifikat" name="sertifikat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="form-control @error('sertifikat') is-invalid @enderror" @required(!$p)>
                    <div class="small text-muted mt-2" style="font-size: 11px;">Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Maks. 5 MB)</div>
                </div>
            </div>

            <!-- Pilihan Peringkat Prestasi (Lap. hal. 108) -->
            <div class="col-md-5">
                <label class="form-label small fw-bold">Peringkat / Hasil Prestasi <span class="text-danger">*</span></label>
                <div class="vstack gap-2">
                    @foreach (\App\Models\Prestasi::PEROLEHAN as $pk => $plabel)
                        <div class="form-check p-2 rounded-3 border bg-white ps-4">
                            <input class="form-check-input" type="radio" name="perolehan" id="perolehan_{{ $pk }}"
                                value="{{ $pk }}" @checked(old('perolehan', $p->perolehan ?? 'juara_1') === $pk) required>
                            <label class="form-check-label fw-semibold small" for="perolehan_{{ $pk }}">
                                {{ $plabel }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Halaman Upload Dokumentasi (Lap. hal. 108-109) -->
    <div class="content-card mb-4" id="section-upload-dokumentasi">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="bi bi-camera-fill text-primary"></i> Upload Dokumentasi Pendukung (Opsional)
            </h5>
            <span class="badge bg-light text-dark border">Langkah 3</span>
        </div>

        @if ($dokLama->isNotEmpty())
            <p class="small text-muted mb-2">Dokumentasi tersimpan (centang jika ingin menghapus foto):</p>
            <div class="row g-3 mb-3">
                @foreach ($dokLama as $d)
                    <div class="col-6 col-md-3">
                        <div class="card h-100 border rounded-3 p-1">
                            <img src="{{ route('berkas.dokumentasi', $d) }}" alt="{{ $d->nama_file }}"
                                class="rounded-2 w-100" style="height:120px; object-fit:cover;" loading="lazy">
                            <div class="form-check mt-1 ps-4">
                                <input class="form-check-input" type="checkbox" name="hapus_dokumentasi[]"
                                    value="{{ $d->id }}" id="hapus{{ $d->id }}"
                                    @checked(in_array($d->id, array_map('intval', old('hapus_dokumentasi', []))))>
                                <label class="form-check-label text-danger small" for="hapus{{ $d->id }}" style="font-size: 11px;">
                                    Hapus
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div id="dokumentasi-wrapper" class="vstack gap-2 mb-3"></div>

        <button type="button" id="tambah-dokumentasi" class="btn btn-outline-secondary btn-sm rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Foto / Dokumen Lainnya
        </button>
        <div class="form-text small mt-2">
            Dokumentasi dapat berupa foto saat mengikuti kegiatan/lomba, foto bersama sertifikat, atau bukti pendukung lainnya. Format: PDF, DOC, DOCX, JPG, PNG.
        </div>
    </div>

    <!-- Tombol Aksi: Batal & Simpan / Upload (Lap. hal. 107-109) -->
    <div class="d-flex align-items-center justify-content-end gap-3 mt-4">
        <a href="{{ $p ? route('mahasiswa.prestasi.show', $p) : route('mahasiswa.prestasi.index') }}"
            class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold">
            Batal
        </a>
        <button type="submit" class="btn btn-olive px-5 py-2 rounded-3 fw-bold shadow">
            <i class="bi bi-cloud-arrow-up-fill me-1"></i> {{ $submitLabel }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    (function() {
        const wrapper = document.getElementById('dokumentasi-wrapper');
        const tombol = document.getElementById('tambah-dokumentasi');
        const maks = {{ $sisaSlot }};
        let urutan = 0;

        function tambah() {
            if (wrapper.children.length >= maks) {
                return;
            }
            const i = urutan++;
            const baris = document.createElement('div');
            baris.className = 'row g-2 align-items-center p-2 rounded-3 bg-light border';
            baris.innerHTML =
                '<div class="col-md-5"><input type="file" class="form-control" name="dokumentasi[' + i + ']" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" maxlength="1000" name="keterangan_dokumentasi[' + i + ']" placeholder="Keterangan dokumentasi (opsional)"></div>' +
                '<div class="col-md-1 text-center"><button type="button" class="btn btn-outline-danger btn-sm rounded-circle" title="Hapus"><i class="bi bi-trash"></i></button></div>';

            baris.querySelector('button').addEventListener('click', function() {
                baris.remove();
                tombol.disabled = false;
            });
            wrapper.appendChild(baris);
            tombol.disabled = wrapper.children.length >= maks;
        }

        tombol.addEventListener('click', tambah);
        if (maks === 0) {
            tombol.disabled = true;
        }
    })();
</script>
@endpush
