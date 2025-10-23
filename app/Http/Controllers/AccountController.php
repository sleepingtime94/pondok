<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLegacy;
use App\Models\SetupKec;

class AccountController extends Controller
{
    public function index()
    {
        if (!jadwal_buka()) {
        return response()->view('admin.jadwal.tutup');
        }
        
        $user = UserLegacy::find(session('auth_user_id'));
        
        if ($user && $user->active != 0) {
            $kecamatans = SetupKec::orderBy('nama')->get();
            return view('account.index', compact('user', 'kecamatans'));
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Akun Anda tidak dapat diakses.');
    }

    public function update(Request $request)
    {
        $user = UserLegacy::find(session('auth_user_id'));

        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sesi tidak valid.');
        }

        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Data akun berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = UserLegacy::find(session('auth_user_id'));

        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sesi tidak valid.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('password_updated', true);
    }
}