<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display the registration form
     */
    public function index()
    {
        return view('auth.Register.register');
    }

    /**
     * Handle registration attempt
     */
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        try {
            // Create new user
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Login the user
            Auth::login($user);

            // Show success message
            session()->flash('success', 'Selamat datang, ' . $user->name . '! Registrasi berhasil.');

            // Redirect to dashboard
            return redirect('/admin/dashboard');

        } catch (\Exception $e) {
            // Show error message
            session()->flash('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');

            return back()->withInput($request->except('password'));
        }
    }
}
