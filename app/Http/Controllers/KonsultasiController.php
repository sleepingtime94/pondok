<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
use App\Models\Konsultasi;
use Carbon\Carbon;

class KonsultasiController extends Controller
{
    /**
     * Tampilkan formulir konsultasi dengan data dropdown.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        // Ambil data jenis pengaduan dari tabel setup_pengaduan yang berstatus aktif
        $jenisPengaduan = DB::table('jenis_konsultasi')
                             ->where('aktif', 'Y')
                             ->orderBy('keterangan', 'asc')
                             ->get();
        
        return view('formulir-konsultasi', compact('jenisPengaduan'));
    }

    /**
     * Proses data yang dikirim dari formulir konsultasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitForm(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:120',
            'nomor_hp' => 'required|string|max:14',
            'jenis_konsultasi' => 'required|integer', 
            'isi_informasi' => 'required|string',
            'file_pendukung.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
    
        // Memulai transaksi database
        DB::beginTransaction();
    
        try {
            // 2. Tentukan ID Konsultasi (otomatis)
            $tanggal = Carbon::now();
            $prefix = $tanggal->format('dmy') . 'KSL';

            $lastKonsultasi = Konsultasi::where('id_konsul', 'like', $prefix . '%')
                                        ->orderBy('id_konsul', 'desc')
                                        ->first();
            
            $nextNumber = 1;
            if ($lastKonsultasi) {
                $lastNumber = (int) substr($lastKonsultasi->id_konsul, -3);
                $nextNumber = $lastNumber + 1;
            }
    
            $id_konsul = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            
            // 3. Simpan file dan dapatkan path
            $filePaths = [];
            if ($request->hasFile('file_pendukung')) {
                foreach ($request->file('file_pendukung') as $file) {
                    $path = $file->store('konsultasi', 'public');
                    $filePaths[] = $path;
                }
            }
            
            // 4. Siapkan data untuk disimpan
            $data = [
                'id_konsul' => $id_konsul,
                'id_jenis' => $request->jenis_konsultasi,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'no_hp' => $request->nomor_hp,
                'isi_pengaduan' => $request->isi_informasi, // Gunakan nama field yang benar sesuai tabel
                'tgl_pengaduan' => $tanggal->toDateString(),
                'jam_pengaduan' => $tanggal->format('H:i:s'),
                'status' => '1',
                // Field yang akan kosong
                'respon_awal' => '',
                'solusi' => '',
                'tgl_respon' => null, 
                'jam_respon' => null, 
                'tgl_selesai' => null, 
                'jam_selesai' => null, 
                'user_respon' => null, 
                'user_selesai' => null, 
            ];
            
            // Masukkan path file ke field dok_dukung
            for ($i = 0; $i < 6; $i++) {
                $data["dok_dukung" . ($i + 1)] = $filePaths[$i] ?? null;
            }
            
            // 5. Simpan data ke database
            Konsultasi::create($data);
    
            // Commit transaksi jika semua berhasil
            DB::commit();
    
            return response()->json(['success' => true, 'id_konsul' => $id_konsul]);
    
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();
            // Logging error untuk debugging
            // Log::error('Gagal menyimpan konsultasi: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
}