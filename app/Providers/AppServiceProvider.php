<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tampilan memakai Bootstrap (sesuai laporan: HTML, CSS, JS, Bootstrap)
        Paginator::useBootstrapFive();

        // Jumlah notifikasi belum dibaca untuk badge di navbar mahasiswa
        View::composer('layout.app', function ($view) {
            $user = auth()->user();

            $view->with(
                'jumlahNotifikasi',
                $user && $user->isMahasiswa()
                    ? $user->notifikasi()->whereNull('dibaca_pada')->count()
                    : 0
            );
        });
    }
}
