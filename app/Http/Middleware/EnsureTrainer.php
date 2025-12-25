<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureTrainer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Redirect if not a trainer
        if (Auth::check() && Auth::user()->user_role !== 'trainer') {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
