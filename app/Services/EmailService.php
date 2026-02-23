<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    protected array $config = [];

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig(): void
    {
        $this->config = [
            'host' => SystemSetting::getValue('mail_host') ?: env('MAIL_HOST', '127.0.0.1'),
            'port' => (int) (SystemSetting::getValue('mail_port') ?: env('MAIL_PORT', 587)),
            'username' => SystemSetting::getValue('mail_username') ?: env('MAIL_USERNAME'),
            'password' => SystemSetting::getValue('mail_password') ?: env('MAIL_PASSWORD'),
            'encryption' => SystemSetting::getValue('mail_encryption') ?: env('MAIL_ENCRYPTION', 'tls'),
            'from_address' => SystemSetting::getValue('mail_from_address') ?: env('MAIL_FROM_ADDRESS'),
            'from_name' => SystemSetting::getValue('mail_from_name') ?: env('MAIL_FROM_NAME', config('app.name', 'System')),
            'debug' => (int) env('MAIL_DEBUG', 0),
        ];
    }

    public function updateConfig(array $config): void
    {
        $this->config = array_merge($this->config, $config);
    }

    public function send(string|array $to, string $subject, string $body, ?string $attachmentPath = null, ?string $attachmentName = null): bool
    {
        $maxRetries = 2;

        for ($attempt = 0; $attempt <= $maxRetries; $attempt++) {
            try {
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.host', $this->config['host']);
                Config::set('mail.mailers.smtp.port', (int) $this->config['port']);
                Config::set('mail.mailers.smtp.username', $this->config['username']);
                Config::set('mail.mailers.smtp.password', $this->config['password']);
                Config::set('mail.mailers.smtp.encryption', $this->config['encryption']);
                Config::set('mail.from.address', $this->config['from_address']);
                Config::set('mail.from.name', $this->config['from_name']);

                $recipients = is_array($to) ? $to : [$to];

                Mail::send([], [], function (Message $message) use ($recipients, $subject, $body, $attachmentPath, $attachmentName) {
                    $message->to($recipients)->subject($subject);
                    $message->html($body);

                    if ($attachmentPath && file_exists($attachmentPath)) {
                        $message->attach($attachmentPath, [
                            'as' => $attachmentName ?? basename($attachmentPath),
                        ]);
                    }
                });

                Log::info('Email sent successfully', [
                    'to' => is_array($to) ? implode(', ', $to) : $to,
                    'subject' => $subject,
                    'attempt' => $attempt,
                ]);

                return true;
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $isConnectionError = stripos($error, 'connect') !== false
                    || stripos($error, 'timeout') !== false
                    || stripos($error, '10060') !== false;

                Log::warning('Email send attempt failed', [
                    'to' => is_array($to) ? implode(', ', $to) : $to,
                    'subject' => $subject,
                    'attempt' => $attempt,
                    'error' => $error,
                ]);

                if ($isConnectionError && $attempt < $maxRetries) {
                    sleep(2);
                    continue;
                }

                return false;
            }
        }

        return false;
    }

    public function testConnection(): array
    {
        $host = (string) ($this->config['host'] ?? '');
        $port = (int) ($this->config['port'] ?? 0);

        $connection = @fsockopen($host, $port, $errno, $errstr, 10);
        if (!$connection) {
            return [
                'success' => false,
                'error' => "Connection failed: {$errstr} (Error {$errno})",
            ];
        }

        fclose($connection);

        return ['success' => true];
    }
}
