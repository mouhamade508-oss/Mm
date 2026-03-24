<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check normal auth OR hardcoded session
        if (!auth()->check() && !$request->session()->get('admin_logged_in')) {
            return redirect('/login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        if (auth()->user() && auth()->user()->email !== 'mouhamad.deop@gmail.com') {
            return redirect('/')->with('error', 'ليس لديك صلاحية الوصول لهذه الصفحة');
        }

        return $next($request);
    }
}
