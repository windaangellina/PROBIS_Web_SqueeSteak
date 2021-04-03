<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('id_aktif') == true &&
            $request->session()->has('username_aktif') == true &&
            $request->session()->has('role_aktif') == true) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
