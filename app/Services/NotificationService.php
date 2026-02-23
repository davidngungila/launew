<?php

namespace App\Services;

use App\Models\NotificationProvider;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendSMS(string $phoneNumber, string $message, ?NotificationProvider $provider = null): bool
    {
        try {
            $provider = $provider ?? NotificationProvider::getPrimary('sms');

            $smsUsername = $provider?->sms_username ?: (SystemSetting::getValue('sms_username') ?: env('SMS_USERNAME'));
            $smsPassword = $provider?->sms_password ?: (SystemSetting::getValue('sms_password') ?: env('SMS_PASSWORD'));
            $smsToken = $provider?->sms_bearer_token ?: (SystemSetting::getValue('sms_bearer_token') ?: env('SMS_BEARER_TOKEN'));
            $smsFrom = $provider?->sms_from ?: (SystemSetting::getValue('sms_from') ?: env('SMS_FROM'));
            $smsUrl = $provider?->sms_url ?: (SystemSetting::getValue('sms_url') ?: env('SMS_URL', 'https://messaging-service.co.tz/api/sms/v2/text/single'));
            $smsMethod = strtolower((string) ($provider?->sms_method ?: (SystemSetting::getValue('sms_method') ?: env('SMS_METHOD', 'post'))));

            if (!$smsUrl) {
                Log::warning('SMS send skipped: sms_url not configured');
                return false;
            }

            if (!$smsFrom) {
                Log::warning('SMS send skipped: sms_from not configured');
                return false;
            }

            if (!$smsToken && (!$smsUsername || !$smsPassword)) {
                Log::warning('SMS send skipped: no authentication configured (set bearer token or username/password)');
                return false;
            }

            $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber ?? '');
            if ($phoneNumber && !str_starts_with($phoneNumber, '255') && strlen($phoneNumber) >= 9) {
                $phoneNumber = '255' . ltrim($phoneNumber, '0');
            }

            if (!$phoneNumber) {
                return false;
            }

            if ($smsMethod === 'get') {
                $url = $smsUrl
                    . '?username=' . urlencode((string) $smsUsername)
                    . '&password=' . urlencode((string) $smsPassword)
                    . '&from=' . urlencode((string) $smsFrom)
                    . '&to=' . urlencode((string) $phoneNumber)
                    . '&text=' . urlencode($message);

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);

                $response = curl_exec($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $err = curl_error($ch);
                curl_close($ch);

                if ($err) {
                    Log::warning('SMS GET failed', ['error' => $err]);
                    return false;
                }

                return $code >= 200 && $code < 300;
            }

            $payload = [
                'from' => (string) $smsFrom,
                'to' => (string) $phoneNumber,
                'text' => (string) $message,
                'reference' => 'lau_' . time(),
            ];

            $request = Http::timeout(30)->acceptJson()->asJson();
            if ($smsToken) {
                $request = $request->withToken($smsToken);
            } else {
                $request = $request->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode((string) $smsUsername . ':' . (string) $smsPassword),
                ]);
            }

            $response = $request->post($smsUrl, $payload);

            if (!$response->successful()) {
                Log::warning('SMS POST failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $smsUrl,
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('SMS send exception', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendEmail(string|array $to, string $subject, string $htmlBody, ?string $attachmentPath = null, ?string $attachmentName = null): bool
    {
        $service = new EmailService();

        return $service->send(
            $to,
            $subject,
            $htmlBody,
            $attachmentPath,
            $attachmentName
        );
    }
}
