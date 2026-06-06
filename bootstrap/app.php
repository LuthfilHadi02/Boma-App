<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🔑 1. Tetap Jaga Kunci Gembok Role Kelompok Lu (Jangan Dihapus!)
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckRole::class,
            'role'  => \App\Http\Middleware\CheckRole::class,
        ]);

        // 🛡️ 2. Jalur Bypass Satpam CSRF untuk Midtrans (Laravel 11 Style)
        $middleware->validateCsrfTokens(except: [
            'payment/callback',
        ]);
    })

     ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('bookings:cancel-expired')->everyFifteenMinutes();
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();