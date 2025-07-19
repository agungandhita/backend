<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Display the login form
     */
    public function index()
    {
        return view('auth.Login.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Get credentials
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Attempt to authenticate
        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Show success message
            session()->flash('success', 'Selamat datang, ' . $user->name . '!');

            // Redirect to intended page or dashboard
            return redirect()->intended('/admin/dashboard');
        }

        // Authentication failed
        session()->flash('error', 'Email atau password yang Anda masukkan salah.');

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        session()->flash('info', 'Anda telah berhasil logout.');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
