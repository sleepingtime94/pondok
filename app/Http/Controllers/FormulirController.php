<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;

class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formulirs = Formulir::all(); // Mengambil semua data formulir dari database

        return view('formulir.index', compact('formulirs'));
    }

    // Pastikan method download ada di dalam class ini
    public function download($filename)
    {
        // Path yang benar sesuai dengan folder Anda
        $path = storage_path('app/public/dok_formulir/' . $filename);

        // Periksa apakah file benar-benar ada
        if (file_exists($path)) {
            // Kirimkan file sebagai respons unduhan
            return response()->download($path);
        } else {
            // Jika file tidak ditemukan, kembalikan error 404
            return abort(404, 'File tidak ditemukan.');
        }
    }
}