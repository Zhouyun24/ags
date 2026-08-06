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
        $middleware->trustProxies(at: '*');
        $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);

        $middleware->redirectTo(
            guests: '/login',
            users: function (Request $request) {
                if (Auth::check()) {
                    $user = Auth::user();
                    $target = match ((int)$user->role) {
                        1 => route('operator.beranda.index'),
                        2 => route('mahasiswa.beranda.index'),
                        3 => route('dosen.beranda.index'),
                        default => null,
                    };
                    if ($target) {
                        return $target;
                    }
                    Auth::logout();
                }
                return '/login';
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->expectsJson() || $request->ajax()) {
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validasi gagal.',
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException || $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data atau halaman tidak ditemukan.',
                    ], 404);
                }

                $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                
                return response()->json([
                    'status' => 'error',
                    'message' => $statusCode === 500 && !config('app.debug') ? 'Terjadi kesalahan internal pada server.' : $e->getMessage(),
                ], $statusCode);
            }
        });
    })->create();

