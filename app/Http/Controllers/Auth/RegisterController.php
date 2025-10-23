<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\SetupKec; // Menggunakan model untuk mengambil data kecamatan
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Tampilkan formulir registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Menggunakan model SetupKec untuk mengambil data kecamatan
        $kecamatans = SetupKec::orderBy('nama')->get();
        return view('auth.register', compact('kecamatans'));
    }

    /**
     * Tangani permintaan registrasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            // Validasi data yang masuk
            $this->validator($request->all())->validate();

            // Buat instance user baru dan kirim event Registered
            event(new Registered($user = $this->create($request->all())));

            // Login user yang baru terdaftar
            Auth::login($user);

            // Redirect ke halaman yang dituju dengan pesan sukses
            return redirect()->intended('/')->with('success', 'Akun berhasil dibuat!');

        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Dapatkan validator untuk permintaan registrasi yang masuk.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'string', 'digits:16', 'unique:users,nik'],
            'kk' => ['required', 'string', 'digits:16'],
            'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15'],
            'kecamatan' => ['required', 'integer', 'exists:kecamatan,id'],
            'desa_kelurahan' => ['required', 'integer', 'exists:desa,kode_desa'],
        ]);
    }

    /**
     * Buat instance pengguna baru setelah registrasi yang valid.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nik' => $data['nik'],
            'kk' => $data['kk'],
            'phone' => $data['phone'],
            'role_id' => 2,
            'id_kec' => $data['kecamatan'],
            'kode_desa' => $data['desa_kelurahan'],
            'active' => 0,
            'photos' => null,
        ]);
    }
}