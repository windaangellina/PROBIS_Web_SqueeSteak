<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AksesKasirMiddleware
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
        if ($request->session()->get('role_aktif') != 1 && $request->session()->get('role_aktif') != 2) {
            // return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membuka laman ini');
            return redirect()->route('permissiondenied');
        }
        return $next($request);
    }
}
