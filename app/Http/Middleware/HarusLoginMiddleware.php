<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HarusLoginMiddleware
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
        if ($request->session()->has('id_aktif') == false ||
            $request->session()->has('username_aktif') == false ||
            $request->session()->has('role_aktif') == false) {
            return redirect()->route('login')
                ->with('error', 'Silahkan login terlebih dahulu');
        }
        return $next($request);
    }
}
