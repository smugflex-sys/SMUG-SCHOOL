<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandleRoleRedirects
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            if ($user->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('Student')) {
                return redirect()->route('student.dashboard');
            } elseif ($user->hasRole('Parent')) {
                return redirect()->route('parent.dashboard');
            } elseif ($user->hasRole('Teacher')) {
                return redirect()->route('teacher.dashboard');
            } elseif ($user->hasRole('Accountant')) {
                return redirect()->route('accountant.dashboard');
            } elseif ($user->hasRole('Librarian')) {
                return redirect()->route('librarian.dashboard');
            }
            // Add any other future roles here
        }

        return $next($request);
    }
}