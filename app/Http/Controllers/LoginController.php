<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan ini diimpor jika Anda membandingkan peran dari model User

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function index()
    {
        return view('auth.login', [ // Asumsi view login Anda ada di auth/login.blade.php
            'title' => 'Login',
        ]);
    }

    /**
     * Menangani upaya otentikasi.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Logika pengalihan berdasarkan peran pengguna
            // Asumsi: Anda memiliki kolom 'role_id' di tabel users dan model 'Role'
            // dengan nama peran seperti 'Admin', 'TU', 'Wadek'.
            if ($user->role && in_array($user->role->name, ['Admin', 'TU', 'Wadek'])) {
                return redirect()->intended(route('dashboard.index')); // Arahkan admin ke dashboard
            }

            // Default untuk pengguna biasa (Mahasiswa, Dosen, dll.)
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Mengelola logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Arahkan ke halaman login setelah logout
    }
}
