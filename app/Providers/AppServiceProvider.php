<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL; // <-- Tambah ini biar ga error
use App\Models\User;

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
        // 1. Kode Penjinak Ngrok biar CSS muncul
        if (str_contains(request()->url(), 'ngrok')) {
            URL::forceScheme('https');
        }

        // 2. Kode Bawaan Kamu untuk Gate Admin (Tetap Aman)
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}