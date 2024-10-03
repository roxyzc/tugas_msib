<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah pengguna memiliki role
            if ($user->roles->isNotEmpty()) {
                if (auth()->user()->roles->pluck('name')->implode(', ') == 'user') return $next($request);
            }
        }

        return redirect()->route('login');
    }
}
