<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $pass = $request->query('pass', $request->post('pass'));
        
        if ($pass !== 'admin123') {
            return redirect('/login')->with('error', 'كلمة المرور الإدارية غير صحيحة');
        }

        return $next($request);
    }
}
