<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CaptchaHelper
{
    public static function verifyTurnstile($turnstileToken, $ipAddress)
    {
        if (!$turnstileToken) {
            return false;
        }

        $secretKey = config('services.turnstile.secret', '0x4AAAAAABlUuuhpoCaKaNS1g6iueUMwU_c');
        $verifyURL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        try {
            $response = Http::asForm()->post($verifyURL, [
                'secret'   => $secretKey,
                'response' => $turnstileToken,
                'remoteip' => $ipAddress,
            ]);

            $resultData = $response->json();

            return $resultData['success'] ?? false;
        } catch (\Exception $e) {
            Log::error('Turnstile verify error: ' . $e->getMessage());
            return false;
        }
    }
}
