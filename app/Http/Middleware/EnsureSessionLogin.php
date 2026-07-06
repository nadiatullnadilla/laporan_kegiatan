<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSessionLogin
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->session()->has('username') || !$request->session()->has('role')) {
            return redirect()->route('login');
        }

        if (!empty($roles) && !in_array($request->session()->get('role'), $roles, true)) {
            return redirect()->route('login', ['switch' => 1])
                ->withErrors(['login' => 'Silakan login menggunakan akun yang sesuai.']);
        }

        return $next($request);
    }
}
