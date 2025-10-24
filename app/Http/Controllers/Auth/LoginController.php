<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CaptchaHelper;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {

        $turnstileResponse = $request->input('turnstileToken');
        if (!CaptchaHelper::verifyTurnstile($turnstileResponse, $request->ip())) {
            return back()->withErrors(['captcha' => 'Captcha tidak valid, silakan coba lagi.'])->onlyInput('nik');
        }

        // Validasi input dasar
        $credentials = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16'],
            'password' => ['required'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus 16 digit.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Tambahkan kondisi 'aktif' ke dalam kredensial
        $credentials = array_merge($credentials, ['active' => 1]);

        // Proses login dengan kredensial yang diperbarui
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Store user ID in session for AccountController
            $request->session()->put('auth_user_id', Auth::id());

            // ✅ PERBAIKAN KRITIS: Redirect SEMUA user ke halaman utama (/) setelah login.
            // Ini MENGHENTIKAN PANGGILAN route('admin.dashboard') yang memicu error Target class.
            return redirect()->intended('/')->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        // Jika gagal, kembalikan pesan kesalahan
        return back()->withErrors([
            'nik' => 'NIK atau Password tidak sesuai, atau akun belum aktif.',
        ])->onlyInput('nik');
    }

    /**
     * Log pengguna keluar dari aplikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
