<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }elseif(Auth::check() && Auth::user()->role_id == 2){
            return redirect()->to(route('/'));
        }

        $request->session()->put('url.intended', $request->url());
        return redirect()->to(route('admin.login'))->withError('Anda harus login terlebih dahulu');
    }
}
