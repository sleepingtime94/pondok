<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Menggunakan alias Log
use App\Models\Transaksi;
use App\Models\UserSyarat;
use App\Models\JenisPelayanan;
use App\Models\Pengambilan;
use App\Http\Requests\PengajuanRequest;
use Carbon\Carbon;
use Exception;

class PengajuanController extends Controller
{
    /**
     * Tampilkan formulir pengajuan.
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('form_pengajuan');
    }

    /**
     * Ambil jenis layanan berdasarkan filter 'keterangan' menggunakan Eloquent.
     * @param string $keteranganFilter
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJenisLayananByKeterangan($keteranganFilter)
    {
        $jenisPelayanan = JenisPelayanan::where('keterangan', $keteranganFilter)
                                        ->orderBy('id', 'asc')
                                        ->get();

        return response()->json($jenisPelayanan);
    }

    /**
     * Ambil opsi pengambilan dokumen menggunakan Eloquent.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPengambilanDokumen()
    {
        $data = Pengambilan::select('id', 'nama')
                          ->orderBy('nama', 'asc')
                          ->get();

        return response()->json($data);
    }

    /**
     * Proses data yang dikirim dari formulir.
     * Menggunakan FormRequest untuk validasi.
     * @param \App\Http\Requests\PengajuanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function submitForm(PengajuanRequest $request)
    {        
        DB::beginTransaction();

        try {
            $user = Auth::user(); // Ambil objek user yang sedang login
            // $userId = Auth::check() ? Auth::id() : null;
            $userId = $user ? $user->id : null;
            $now = Carbon::now();

            // Ambil data wilayah dari user yang login
            // Pastikan field ini benar ada di tabel users
            $idKec = $user ? $user->id_kec : null; 
            $idKel = $user ? $user->kode_desa : null; // Mapping User.kode_desa ke Transaksi.id_kel

            // Format ID TRX
            $datePart = $now->format('ymd');
            // Pastikan 'keterangan' yang digunakan untuk kode TRX adalah nilai yang singkat dan unik (misal: KTP, KK)
            $keteranganPart = strtoupper($request->keterangan); 

            // Query nomor urut dengan lock (penting untuk race condition)
            $lastTrx = Transaksi::where('id_trx', 'like', $datePart . $keteranganPart . '%')
                                 ->orderBy('id_trx', 'desc')
                                 ->lockForUpdate()
                                 ->first();

            $nextNumber = 1;
            if ($lastTrx) {
                // Ambil 3 karakter terakhir (nomor urut)
                // Contoh: 250926KTP001 -> '001'
                $lastNumber = (int) substr($lastTrx->id_trx, -3);
                $nextNumber = $lastNumber + 1;
            }

            $sequencePart = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $idTrx = $datePart . $keteranganPart . $sequencePart; // Contoh: 250926KTP001

            Log::info('ID TRX yang akan dibuat:', ['id_trx' => $idTrx]);

            // Simpan ke database
            Transaksi::create([
                'id_trx'         => $idTrx,
                'no_resi'        => $request->no_resi,
                'id_user'        => $userId,
                'nik'            => $request->nik,
                'kk'             => $request->kk,
                'nama'           => $request->nama,
                'keterangan'     => $request->isi_informasi, // Nama field ini sudah benar
                'id_dokumen'     => $request->jenis_layanan, // 💡 KOREKSI: Seharusnya menyimpan ID Jenis Layanan yang dipilih
                'id_kec'         => $idKec, 
                'id_kel'         => $idKel, 
                'tgl'            => now(),
                'status'         => 1,
                'ikm'            => $request->ikm,
                'pengambilan_id' => $request->pengambilan_id, // 💡 KOREKSI: Menggunakan nama field dari form
            ]);

            Log::info('Transaksi berhasil disimpan dengan ID:', ['id_trx' => $idTrx]);

            // Simpan file...
            if ($request->has('file_pendukung')) { // Gunakan has() untuk array file
                foreach ($request->file('file_pendukung') as $file) {
                    if ($file) { // Pastikan file tidak null
                        $filename = time() . '_' . $file->getClientOriginalName();
                        // Gunakan put() agar tidak perlu menentukan disk setiap kali jika 'public' adalah default
                        // $path = $file->storeAs('uploads', $filename, 'public'); 
                        // ✅ Simpan langsung di public/uploads (tanpa symlink)
                        $destinationPath = public_path('uploads');
                        $file->move($destinationPath, $filename);
                        $path = 'uploads/' . $filename;

                        UserSyarat::create([
                            'id_trx' => $idTrx,
                            'file'   => $path,
                        ]);
                    }
                }
            }

            DB::commit();

            // ✅ RESPONS SUKSES DENGAN id_trx YANG JELAS
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'id_trx'  => $idTrx, // Ini kunci yang dicari oleh JavaScript
            ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Gagal menyimpan transaksi:', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data. Detail: ' . $e->getMessage()
            ], 500);
        }
    }
}
