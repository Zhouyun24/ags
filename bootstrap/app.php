<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);

        $middleware->redirectTo(
            guests: '/login',
            users: function (Request $request) {
                if (Auth::check()) {
                    $user = Auth::user();
                    return match ((int)$user->role) {
                        1 => route('operator.daftar'),
                        2 => route('mahasiswa.beranda.index'),
                        3 => route('dosen.beranda.index'),
                        default => route('login'),
                    };
                }
                return '/login';
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

