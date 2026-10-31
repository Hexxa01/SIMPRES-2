@php
    $st = 'menunggu';

    if (isset($prestasi)) {
        if ($prestasi instanceof \Illuminate\Pagination\AbstractPaginator || $prestasi instanceof \Illuminate\Support\Collection) {
            $st = 'menunggu';
        } elseif (is_object($prestasi)) {
            if (isset($prestasi->status_verifikasi)) {
                $st = $prestasi->status_verifikasi;
            } elseif (method_exists($prestasi, 'getAttribute')) {
                $st = $prestasi->getAttribute('status_verifikasi') ?? 'menunggu';
            }
        } elseif (is_array($prestasi)) {
            $st = $prestasi['status_verifikasi'] ?? 'menunggu';
        }
    }

    if (!isset($prestasi) || (is_object($prestasi) && (method_exists($prestasi, 'count') && !isset($prestasi->status_verifikasi) && !method_exists($prestasi, 'getAttribute')))) {
        // fallback
    }

    $st = $st ?? ($status ?? 'menunggu');

    $badgeClass = match($st) {
        'terverifikasi' => 'success',
        'menunggu' => 'warning text-dark',
        'perlu_perbaikan' => 'danger',
        'ditolak' => 'secondary',
        default => 'secondary'
    };
    $label = match($st) {
        'terverifikasi' => 'Terverifikasi',
        'menunggu' => 'Menunggu Verifikasi',
        'perlu_perbaikan' => 'Perlu Perbaikan',
        'ditolak' => 'Ditolak',
        default => is_string($st) ? ucfirst(str_replace('_', ' ', $st)) : 'Menunggu'
    };
@endphp
<span class="badge bg-{{ $badgeClass }} px-2 py-1 rounded-pill" style="font-size: 11px;">
    {{ $label }}
</span>
