<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL; 
use App\Models\User;
// 📝 TAMBAHKAN IMPORT INI DI ATAS
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🛠️ 1. SUNTIKAN SAKTI BIAR PAGINATION UKURANNYA NORMAL (BOOTSTRAP 5)
        Paginator::useBootstrapFive();

        // 2. Kode Penjinak Ngrok biar CSS muncul
        if (str_contains(request()->url(), 'ngrok')) {
            URL::forceScheme('https');
        }

        // 3. Kode Bawaan Kamu untuk Gate Admin (Tetap Aman)
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}