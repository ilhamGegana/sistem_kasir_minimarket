<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ModelPengguna;


class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Ini adalah halaman login yang di-extend dari authMaster.blade.php
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba autentikasi pengguna
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Ambil pengguna yang sedang login
            $user = Auth::user();

            // Periksa peran pengguna
            if ($user->role == 'kasir') {
                // Jika peran kasir, arahkan ke halaman barang/index
                return redirect()->route('kasir.index')->with('success', 'Login berhasil sebagai kasir.');
            } elseif ($user->role == 'admin') {
                // Jika peran admin, arahkan ke halaman lain
                // return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin.');
            }

            // Default redirect jika tidak ada peran yang cocok
            return redirect('/')->with('error', 'Peran pengguna tidak dikenali.');
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Login gagal, periksa kembali kredensial.',
        ])->withInput();
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
