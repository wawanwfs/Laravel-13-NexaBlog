<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin,superadmin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('toast_error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        if (!$user->hasRole($roles)) {
            // If AJAX/API request, return JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak. Anda tidak memiliki izin.'], 403);
            }

            // Redirect back (or to landing if no referer) with toast error
            $previous = url()->previous();
            $current  = $request->url();

            // Avoid redirect loop (if previous === current, go to landing)
            $fallback = ($previous && $previous !== $current)
                ? redirect()->back()
                : redirect()->route('landing');

            return $fallback->with('toast_error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        return $next($request);
    }
}

