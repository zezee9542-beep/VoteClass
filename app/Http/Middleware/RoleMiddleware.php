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
     * Checks that the user is authenticated AND has the required role.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Redirect user back to their own dashboard
            $userRole = Auth::user()->role;
            return match ($userRole) {
                'admin'     => redirect()->route('admin.dashboard'),
                'walikelas' => redirect()->route('walikelas.dashboard'),
                'siswa'     => redirect()->route('siswa.dashboard'),
                default     => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
