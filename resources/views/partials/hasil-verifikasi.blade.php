<div class="card mb-3">
    <div class="card-header fw-semibold">Status Verifikasi</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-4">Status</dt>
            <dd class="col-sm-8">@include('partials.status-badge', ['prestasi' => $prestasi])</dd>

            <dt class="col-sm-4">Skor</dt>
            <dd class="col-sm-8">{{ $prestasi->skorTampil() }}</dd>

            <dt class="col-sm-4">Diverifikasi oleh</dt>
            <dd class="col-sm-8">
                {{ $prestasi->verifikator->nama ?? '-' }}
                @if ($prestasi->diverifikasi_pada)
                    <small class="text-muted">({{ $prestasi->diverifikasi_pada->format('d/m/Y H:i') }})</small>
                @endif
            </dd>

            <dt class="col-sm-4">Catatan Admin</dt>
            <dd class="col-sm-8">{!! nl2br(e($prestasi->catatan_revisi ?: '-')) !!}</dd>
        </dl>
    </div>
</div>
