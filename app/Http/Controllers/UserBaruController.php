<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserBaruController extends Controller
{
    public function index(Request $request)
    {
        $users = \App\Models\User::where('active', 0)->latest()->paginate(10); // ✅ Paginate!

        return view('user_baru', compact('users'));
    }

    public function action(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $action = $request->input('action');
        $phone = $request->input('phone');
        $reason = $request->input('reason');


        try {
            switch ($action) {
                case 'activate':
                    $otp = \App\Helpers\generateOtp(6);

                    $user->update([
                        'active' => 1,
                        'activation_code' => $otp,
                        'activation_code_expires_at' => now()->addMinutes(10),
                    ]);

                    // Notifikasi WA akun diterima
                    $message = "Pendaftaran akun berhasil, silahkan login dan akses menu layanan.\n\n_https://pondok.dukcapil.tapinkab.go.id_";
                    $this->sendWhatsapp($phone, $message);


                    return response()->json(['message' => 'User berhasil diaktifkan!']);
                    break;

                case 'edit':
                    $validated = $request->validate([
                        'name' => 'nullable|string|max:255',
                        'email' => 'nullable|email|max:255',
                        'nik' => 'nullable|string|max:255',
                        'kk' => 'nullable|string|max:255',
                        'phone' => 'nullable|string|max:255',
                    ]);

                    $user->update($validated);
                    return response()->json(['message' => 'Data user berhasil diperbarui!']);
                    break;

                case 'reject':
                    $reason = $request->input('reason');
                    // Opsional: simpan alasan ke log atau kolom tambahan
                    // $user->delete(); // atau update status jadi 'rejected'
                    $user->update(['active' => 0]);

                    // Notifikasi WA akun ditolak
                    $message = "Pendaftaran akun ditolak, alasan: {$reason}\n\n_https://pondok.dukcapil.tapinkab.go.id_";
                    $this->sendWhatsapp($phone, $message);

                    return response()->json(['message' => 'Pendaftaran akun ditolak!']);
                    break;

                default:
                    return response()->json(['message' => 'Aksi tidak valid'], 400);
            }

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function resetOtp($id)
    {
        $user = \App\Models\User::findOrFail($id);

        $otp = rand(100000, 999999);
        $user->update([
            'activation_code' => $otp,
            'activation_code_expires_at' => now()->addMinutes(10),
        ]);

        return response()->json([
            'message' => "OTP baru: {$otp} (berlaku 10 menit)"
        ]);
    }

    // Contoh di UserController@activate
    public function activate(User $user)
    {
        $user->active = 1;
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diaktifkan.');
    }


    public function sendWhatsapp($phone, $message)
    {
        $url = "http://36.91.137.28:7000/send-message";
        $token = "pondok6305";

        // Data yang dikirim dalam format JSON
        $payload = [
            "phone"   => $phone,
            "message" => $message,
            "key" => $token
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);

        // Set opsi cURL
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                // "Authorization: Bearer $token"
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload)
        ]);

        // Eksekusi request
        $response = curl_exec($ch);

        // Tangani error
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error_msg];
        }

        // Tutup koneksi
        curl_close($ch);

        // Decode hasil response (jika JSON)
        $result = json_decode($response, true);

        return $result ?: ["success" => false, "error" => "Invalid response"];
    }
}
