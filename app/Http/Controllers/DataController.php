<?php
namespace App\Http\Controllers;

// app/Http/Controllers/DataController.php

use App\Models\SetupKel; // Model Kelurahan Anda

class DataController extends Controller
{
    public function getDesaByKecamatan(Request $request)
    {
        $id_kecamatan = $request->query('id_kecamatan');

        if (!$id_kecamatan) {
            return response()->json([], 200);
        }

        // Ambil data kelurahan/desa yang memiliki foreign key id_kecamatan
        $desaKelurahan = SetupKel::where('id_kecamatan', $id_kecamatan)
            // Pastikan Anda hanya mengambil field yang dibutuhkan untuk efisiensi
            ->get(['id', 'kode_desa', 'nama_kelurahan']); 

        // Ubah nama field agar sesuai dengan yang diharapkan JavaScript (optional)
        $data = $desaKelurahan->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_desa' => $item->kode_desa, // Field yang akan digunakan untuk value
                'nama' => $item->nama_kelurahan, // Field yang akan digunakan untuk textContent
            ];
        });

        return response()->json($data);
    }
}