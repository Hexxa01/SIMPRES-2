<?php

namespace App\Policies;

use App\Models\Prestasi;
use App\Models\User;

class PrestasiPolicy
{
    public function view(User $user, Prestasi $prestasi): bool
    {
        return $user->isAdmin()
            || $user->isPimpinan()
            || (
                $user->isMahasiswa()
                && $prestasi->id_mahasiswa === $user->id
            );
    }

    public function update(User $user, Prestasi $prestasi): bool
    {
        return $user->isMahasiswa()
            && $prestasi->id_mahasiswa === $user->id
            && $prestasi->status_verifikasi === 'perlu_perbaikan';
    }

    public function delete(User $user, Prestasi $prestasi): bool
    {
        return $user->isAdmin()
            && $prestasi->status_verifikasi !== 'terverifikasi';
    }

    public function verify(User $user, Prestasi $prestasi): bool
    {
        return $user->isAdmin()
            && $prestasi->status_verifikasi === 'menunggu';
    }
}
