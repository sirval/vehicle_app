<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait Utils
{

    protected function generateVerificationCode($phoneNumber)
    {
        $hashedNumber = abs(crc32(Hash::make($phoneNumber . microtime(true))));
        $uniqueCode = $hashedNumber % 900000 + 100000;

        // Check if the generated number already exists in the database
        while (User::where('verif_code', $uniqueCode)->exists()) {
            $hashedNumber = abs(crc32(Hash::make($phoneNumber . microtime(true))));
            $uniqueCode = $hashedNumber % 900000 + 100000;
        }

        return $uniqueCode;
    }

    protected function message($user)
    {
        return 'Welcome to ' . env('APP_NAME') . '. Your verification code is ' . $user->verif_code;
    }

    protected function sendSms($user): bool
    {
        $baseUrl = config('sendchamp.baseUrl') . '/sms/send';
        $publicKey = config('sendchamp.publicKey');
        $sender = config('sendchamp.sender');

        $response = Http::withHeaders([
                'Authorization' => "Bearer {$publicKey}",
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
            ])->post($baseUrl, [
                'to' => [$user->phone ?? $user['phone']],
                'message' => $this->message($user),
                'sender_name' => $sender,
                'route' => 'dnd',
                'mode' => 'live',
            ]);
            Log::info($user);
        if ($response->status() === 200) {
            return true;
        } else {
            Log::info('User <----> '. $user->phone. ' response data: '. $response);
            return false;
        }
    }

    protected function maskPhoneNumber($phoneNumber)
    {
        $countryCodeLength = 3; // (e.g., +234)
        $lastDigitsLength = 2;  // (e.g., 01)
        $maskedLength = strlen($phoneNumber) - ($countryCodeLength + $lastDigitsLength);

        return substr($phoneNumber, 0, $countryCodeLength + 1) . str_repeat('x', $maskedLength) . substr($phoneNumber, - $lastDigitsLength);
    }
}