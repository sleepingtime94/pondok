<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan formulir login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {

        // Validasi Turnstile (Cloudflare CAPTCHA)
        // $turnstileResponse = $request->input('turnstileToken');
        // if (!$turnstileResponse) {
        //     return back()->withErrors(['captcha' => 'Captcha wajib diisi.'])->onlyInput('nik');
        // }

        // $secretKey = config('services.turnstile.secret', '0x4AAAAAABlUuuhpoCaKaNS1g6iueUMwU_c');
        // $verifyURL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        // try {
        //     $client = new \GuzzleHttp\Client(['timeout' => 5]);
        //     $response = $client->post($verifyURL, [
        //         'form_params' => [
        //             'secret'   => $secretKey,
        //             'response' => $turnstileResponse,
        //             'remoteip' => $request->ip(),
        //         ],
        //     ]);

        //     $resultData = json_decode($response->getBody()->getContents(), true);

        //     if (!isset($resultData['success']) || !$resultData['success']) {
        //         return back()->withErrors(['captcha' => 'Captcha tidak valid, silakan coba lagi.'])->onlyInput('nik');
        //     }
        // } catch (\Exception $e) {
        //     // Log error jika diperlukan: \Log::error('Turnstile verify error: ' . $e->getMessage());
        //     return back()->withErrors(['captcha' => 'Gagal memverifikasi captcha, silakan coba lagi.'])->onlyInput('nik');
        // }

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
