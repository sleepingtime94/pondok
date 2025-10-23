<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\UserSyarat;
use App\Models\JenisPelayanan;
use App\Models\Pengambilan; // ✅ Tambahkan ini
use Exception;

class PengajuanUlangController extends Controller
{
    public function showForm($id_trx)
    {
        // Cari transaksi yang ditolak
        $transaksi = Transaksi::where('id_trx', $id_trx)
            ->where('status', 5) // Hanya jika status = Ditolak
            ->firstOrFail();

        // Ambil jenis layanan
        $jenisLayanan = JenisPelayanan::find($transaksi->id_dokumen);

        // Ambil file lama
        $fileLama = UserSyarat::where('id_trx', $id_trx)->get();

        // ✅ Ambil semua opsi pengambilan dokumen
        $pengambilanDokumens = Pengambilan::all();

        // Ambil semua jenis pelayanan untuk dropdown
        if ($jenisLayanan) {
            $jenisPelayanans = JenisPelayanan::where('keterangan', $jenisLayanan->keterangan)->get();
        } else {
            $jenisPelayanans = JenisPelayanan::all();
        }

        return view('pengajuan_ulang', compact(
            'transaksi',
            'jenisLayanan',
            'jenisPelayanans',
            'fileLama',
            'pengambilanDokumens'
        ));
    }

    public function submitForm(Request $request, $id_trx)
    {
        DB::beginTransaction();

        try {
            // Validasi
            $request->validate([
                'file_pendukung' => 'nullable|array',
                'file_pendukung.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
                'keterangan' => 'required|string',
            ]);

            // Cari transaksi yang ditolak
            $transaksi = Transaksi::where('id_trx', $id_trx)
                ->where('status', 5)
                ->firstOrFail();

            // Update transaksi
            $transaksi->update([
                'keterangan' => $request->keterangan,
                'status' => 6, // Pengajuan Ulang
            ]);

            // Simpan file baru
            if ($request->hasFile('file_pendukung')) {
                foreach ($request->file('file_pendukung') as $file) {
                    if ($file) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $destinationPath = public_path('uploads');
                        $file->move($destinationPath, $filename);
                        $path = 'uploads/' . $filename;

                        UserSyarat::create([
                            'id_trx' => $transaksi->id_trx,
                            'file'   => $path,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('tracking.show', $transaksi->id_trx)
                ->with('success', 'Permohonan berhasil diajukan ulang!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function hapusFile($id)
    {
        try {
            $file = UserSyarat::findOrFail($id);
            $filePath = storage_path('app/public/' . $file->file);

            // Hapus file fisik
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus dari database
            $file->delete();

            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file.'
            ], 500);
        }
    }
}