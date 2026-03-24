<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/admin/products');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ✅ Hardcoded Admin for Railway (no DB needed)
        if ($credentials['email'] === 'mouhamad.deop@gmail.com' && $credentials['password'] === 'admin123') {
// Create a fake session for admin
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_user', ['id' => 1, 'name' => 'Admin', 'email' => $credentials['email']]);
            $request->session()->put('admin_email', $credentials['email']);
            $request->session()->regenerate();
            
            return redirect()->intended('/admin/products');
        }

        // ✅ DB auth commented out for hardcoded only
        // if (Auth::attempt($credentials, $request->boolean('remember'))) {
        //     $request->session()->regenerate();
        //     
        //     return redirect()->intended(route('admin.products.index'));
        // }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('admin_logged_in');
        $request->session()->forget('admin_user');
        $request->session()->forget('admin_email');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}

