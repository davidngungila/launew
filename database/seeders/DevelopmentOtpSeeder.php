<?php

namespace Database\Seeders;

use App\Models\OtpLogin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentOtpSeeder extends Seeder
{
    public function run(): void
    {
        // Create a development OTP for testing
        $user = User::where('email', 'superadmin@lauparadise.com')->first();
        
        if ($user) {
            // Create a predictable OTP for development
            $otp = '123456'; // Fixed OTP for development
            $token = bin2hex(random_bytes(24));
            
            OtpLogin::query()->where('user_id', $user->id)->delete();
            
            OtpLogin::query()->create([
                'user_id' => $user->id,
                'otp_hash' => Hash::make($otp),
                'verify_token' => $token,
                'expires_at' => now()->addMinutes(30), // Extended for development
                'attempts' => 0,
                'sent_at' => now(),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Development Seeder',
            ]);

            $this->command->info("Development OTP created for superadmin@lauparadise.com");
            $this->command->info("OTP Code: {$otp}");
            $this->command->info("Verify Link: " . route('login.otp.verify_link', ['token' => $token]));
            $this->command->info("");
            $this->command->info("Login Process:");
            $this->command->info("1. Go to /login");
            $this->command->info("2. Enter: superadmin@lauparadise.com / Admin@12345");
            $this->command->info("3. You'll be redirected to OTP page");
            $this->command->info("4. Enter OTP: {$otp}");
            $this->command->info("5. Or use the verify link above");
        }
    }
}
