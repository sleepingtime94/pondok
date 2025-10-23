<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $orders = Transaksi::where('id_user', $userId)
            ->with(['dokumen', 'pengambilan'])
            ->get();

        if (!jadwal_buka()) {
        return response()->view('admin.jadwal.tutup');
        }
        
        // Reset notifikasi saat user membuka halaman Lacak
        session(['unread_count' => 0]);

        return view('tracking.index', compact('orders'));
    }

    public function show($id_trx)
    {
        $transaksi = Transaksi::with(['dokumen', 'pengambilan', 'files', 'user', 'userDokumen'])
            ->where('id_trx', $id_trx)
            ->first();

        if (!$transaksi) {
            abort(404, 'Transaksi dengan ID ' . $id_trx . ' tidak ditemukan.');
        }

        return view('tracking.show', compact('transaksi'));
    }
}