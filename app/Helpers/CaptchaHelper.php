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

        $secretKey = config('services.turnstile.secret');
        $verifyURL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        try {
            $response = Http::asForm()->post($verifyURL, [
                'secret'   => $secretKey,
                'response' => $turnstileToken,
                'remoteip' => $ipAddress,
            ]);

            $result = $response->json();

            if (!empty($result['success']) && $result['success'] === true) {
                return true;
            }

            Log::warning('Turnstile verification failed', [
                'response' => $result,
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Turnstile verification error: ' . $e->getMessage());
            return false;
        }
    }
}
