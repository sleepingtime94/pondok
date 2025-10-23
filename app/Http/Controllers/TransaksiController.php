<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\UserSyarat;

class TransaksiController extends Controller
{
    /**
     * Tampilkan halaman tracking berdasarkan ID TRX.
     *
     * @param  string  $idTrx
     * @return \Illuminate\View\View
     */
    public function show($idTrx)
    {
        // Ambil data transaksi beserta relasi
        $transaksi = Transaksi::with([
            'user',           // relasi ke User
            'dokumen',        // relasi ke JenisPelayanan
            'pengambilan',    // relasi ke Pengambilan
            'files'           // relasi ke UserSyarat (foto)
        ])->findOrFail($idTrx);

        return view('tracking', compact('transaksi'));
    }

    /**
     * Tampilkan semua transaksi (opsional, untuk admin).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $transaksi = Transaksi::with('user', 'dokumen', 'pengambilan')
                              ->latest()
                              ->paginate(10);

        return view('tracking.index', compact('transaksi'));
    }

    /**
     * Update status transaksi (opsional).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $idTrx
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $idTrx)
    {
        $request->validate([
            'status' => 'required|integer|in:1,2,3,4,5,6,7,8',
        ]);

        // ✅ Cari berdasarkan id_trx (bukan id)
        $transaksi = Transaksi::where('id_trx', $idTrx)->firstOrFail();

        $transaksi->status = $request->status;

        // ✅ Sesuaikan logika dengan penjelasan Anda
        if ($request->status == 2) { // Verifikasi
            $transaksi->tgl_respon = now();
        } 
        elseif ($request->status == 3) { // Proses
            $transaksi->tgl_proses = now();
        } 
        elseif ($request->status == 4) { // Selesai
            $transaksi->tgl_selesai = now();
        } 
        elseif ($request->status == 5 || $request->status == 6 || $request->status == 7) { // Ditolak, Pengajuan Ulang, Komplain
            // updated_at akan otomatis diupdate oleh Laravel saat save()
        } 
        elseif ($request->status == 8) { // Dibatalkan
            $transaksi->deleted_at = now(); // Soft delete
        }

        $transaksi->save(); // ✅ Ini akan memicu observer → simpan log

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function konfirmasi(Request $request, $id)
    {
        // Cari transaksi berdasarkan id_trx (bukan ID primary key!)
        $transaksi = Transaksi::where('id_trx', $id)->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        // Update data
        $updated = $transaksi->update([
            'konfirmasi' => 'Y',
            'tgl_konfirmasi' => now(),
        ]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Konfirmasi berhasil disimpan.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan konfirmasi. Tidak ada perubahan data.'
            ], 500);
        }
    }

    public function submitRating(Request $request, $id_trx)
    {
        try {
            // Cari transaksi berdasarkan id_trx (bukan ID primary key!)
            $transaksi = Transaksi::where('id_trx', $id_trx)->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan.'
                ], 404);
            }

            // Update data rating
            $transaksi->update([
                'rating' => $request->input('rating'), // 1,2,3,4
                'komentar_rating' => $request->input('comment') ?? null,
                'tgl_rating' => now(), // simpan tanggal penilaian
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error submit rating: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan penilaian: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi seperti biasa
        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:16',
            'id_dokumen' => 'required|integer|exists:jenis_pelayanan,id',
            'no_kk' => 'nullable|string|max:16',
            'pengambilan_id' => 'required|integer|exists:pengambilan,id',
            'isi_informasi' => 'required|string',
        ]);

        // ✅ Cek apakah mode edit
        if ($request->filled('mode') && $request->mode === 'edit' && $request->filled('trx_id')) {
            // Update transaksi lama
            $transaksi = Transaksi::where('id_trx', $request->trx_id)
                ->where('status', 5) // Pastikan masih status Ditolak
                ->firstOrFail();

            $transaksi->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'no_kk' => $request->no_kk,
                'keterangan' => $request->isi_informasi,
                'id_dokumen' => $request->id_dokumen,
                'pengambilan_id' => $request->pengambilan_id,
                'status' => 6, // ✅ Ubah ke Pengajuan Ulang
            ]);

            // Handle file upload
            if ($request->hasFile('file_pendukung')) {
                foreach ($request->file('file_pendukung') as $file) {
                    if ($file) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('uploads', $filename, 'public');

                        UserSyarat::create([
                            'id_trx' => $transaksi->id_trx,
                            'file'   => $path,
                        ]);
                    }
                }
            }

            return redirect()->route('tracking.show', $transaksi->id_trx)
                ->with('success', 'Permohonan berhasil diajukan ulang!');
        }

        // Jika bukan mode edit → buat transaksi baru (logika lama)
        $transaksiBaru = new Transaksi();
        $transaksiBaru->id_dokumen = $request->id_dokumen;
        $transaksiBaru->nik = $request->nik;
        $transaksiBaru->nama = $request->nama;
        $transaksiBaru->no_kk = $request->no_kk;
        $transaksiBaru->tgl = now();
        $transaksiBaru->keterangan = $request->isi_informasi;
        $transaksiBaru->pengambilan_id = $request->pengambilan_id;
        $transaksiBaru->status = 1; // Baru

        // Handle file upload untuk transaksi baru
        if ($request->hasFile('file_pendukung')) {
            foreach ($request->file('file_pendukung') as $file) {
                if ($file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('uploads', $filename, 'public');
                    
                    UserSyarat::create([
                        'id_trx' => $transaksiBaru->id_trx,
                        'file'   => $path,
                    ]);
                }
            }
        }

        $transaksiBaru->save();

        return redirect()->route('tracking.show', $transaksiBaru->id_trx)
            ->with('success', 'Permohonan berhasil diajukan!');
    }
}