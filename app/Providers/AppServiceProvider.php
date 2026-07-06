<?php

namespace App\Providers;

use App\Models\Laporan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.sidebar', function ($view) {
            $view->with([
                'total_menunggu_verifikasi' => Laporan::where('status', 'menunggu')->count(),
                'total_revisi_laporan' => Laporan::where('status', 'revisi')->count(),
            ]);
        });
    }
}
