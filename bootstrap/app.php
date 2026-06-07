<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // ── 403 Forbidden → redirect back with toast ──────────
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }
            return redirect()->back()
                ->with('toast_error', 'Akses ditolak. Anda tidak memiliki izin untuk melakukan tindakan ini.');
        });

        // ── 419 CSRF Token Mismatch → redirect back with toast ─
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return redirect()->back()
                ->with('toast_error', 'Sesi Anda telah berakhir. Silakan coba lagi.');
        });

        // ── Unauthenticated → redirect to login with toast ────
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Tidak terautentikasi.'], 401);
            }
            return redirect()->route('login')
                ->with('toast_error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        });

        // ── 404 Not Found → custom view ───────────────────────
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Halaman tidak ditemukan.'], 404);
            }
            return response()->view('errors.404', [], 404);
        });

        // ── 405 Method Not Allowed → redirect back with toast ─
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Metode tidak diizinkan.'], 405);
            }
            return redirect()->back()
                ->with('toast_error', 'Permintaan tidak valid. Silakan coba lagi.');
        });

        // ── 500+ Server Error → custom view ───────────────────
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return null; // Let Laravel handle JSON errors normally
            }
            // Only catch unhandled server errors (500) in production
            if (!config('app.debug') && !($e instanceof \Exception)) {
                return response()->view('errors.500', [], 500);
            }
            return null; // Let Laravel handle in debug mode
        });

    })->create();

