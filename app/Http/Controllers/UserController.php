<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Validation\Rule; // <-- PENTING: Import Rule

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('active', 1);

        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }
        if ($request->filled('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('kecamatan')) {
            $query->where('id_kec', $request->kecamatan);
        }
        if ($request->filled('desa_kel')) {
            $query->where('kode_desa', $request->desa_kel);
        }
        if ($request->filled('level')) {
            $query->where('role_id', $request->level);
        }
        if ($request->filled('no_hp')) {
            $query->where('phone', 'like', '%' . $request->no_hp . '%');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Ambil data desa dengan kecamatan_id
        $allDesa = \App\Models\SetupKel::select('kode_desa', 'nama', 'kecamatan_id')->get();
        $desaByKec = $allDesa->groupBy('kecamatan_id')
            ->map(fn($group) => $group->pluck('nama', 'kode_desa')->toArray())
            ->toArray();

        $perPage = $request->input('per_page', 10);
        $users = $query->paginate($perPage)->appends($request->except('page'));

        $kecamatans = \App\Models\SetupKec::select('id', 'nama')->get();
        $levels = DB::table('roles')->select('id', 'nama')->get();

        return view('admin.user.index', compact('users', 'kecamatans', 'levels', 'desaByKec'));
    }
    
    // FUNGSI BARU (DIPINDAHKAN DARI ADMIN/USERCONTROLLER.PHP)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $levels = DB::table('roles')->select('id', 'nama')->get();
        
        // Asumsi view edit ada di 'admin.user.edit' atau Anda menggunakan modal
        return view('admin.user.edit', compact('user', 'levels'));
    }

    // FUNGSI UPDATE (SUDAH DISEMPURNAKAN)
    public function update(Request $request, $id)
    {
        Log::info('Update user request:', $request->all());
        
        $user = User::findOrFail($id);

        $rules = [
            // Pengecualian ID user saat validasi unique
            'nik' => 'required|numeric|digits:16|unique:users,nik,' . $user->id, 
            'kk' => 'required|numeric|digits:16', 
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, 
            'phone' => 'required|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'id_kec' => 'required|exists:kecamatan,id',
            'kode_desa' => [
                'required',
                // Pastikan Rule diimpor di atas, tidak perlu backslash
                Rule::exists('desa', 'kode_desa')->where(function ($query) use ($request) {
                    return $query->where('kecamatan_id', $request->id_kec);
                }),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ];

        $validated = $request->validate($rules);
        
        // Penanganan Password
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function blokir($id)
    {
        $user = User::findOrFail($id);
        // Menggunakan logika dari Admin/UserController (toggle active)
        $user->active = $user->active == 1 ? 2 : 1; 
        $user->save();

        $status = $user->active == 1 ? 'diaktifkan' : 'diblokir';
        return redirect()->back()->with('success', "User berhasil $status.");
    }
}
