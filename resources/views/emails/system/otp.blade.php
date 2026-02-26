@extends('emails.layout', [
    'title' => $subject ?? 'OTP Verification',
    'heading' => $heading ?? 'Login Verification Code',
    'subheading' => $subheading ?? null,
    'brand_name' => $brand_name ?? 'LAU Paradise Adventure',
    'brand_tagline' => $brand_tagline ?? 'PARADISE ADVENTURE',
    'logo_url' => $logo_url ?? null,
    'website_url' => $website_url ?? null,
    'support_email' => $support_email ?? null,
    'support_phone' => $support_phone ?? null,
    'support_whatsapp' => $support_whatsapp ?? null,
    'footer_note' => $footer_note ?? 'If you did not attempt to login, please secure your account immediately.'
])

@section('content')
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#0f172a;">
        <div style="margin-bottom:14px;">
            Your one-time login code is:
        </div>

        <div style="font-family:Arial,Helvetica,sans-serif;font-size:28px;line-height:32px;font-weight:900;letter-spacing:0.25em;color:#064e3b;background-color:#ecfdf5;border:1px solid #a7f3d0;border-radius:14px;padding:14px 16px;text-align:center;">
            {{ $otp ?? '' }}
        </div>

        <div style="margin-top:14px;color:#334155;font-weight:700;">
            This code expires in {{ (int)($expires_minutes ?? 10) }} minutes.
        </div>

        @if(!empty($verify_url))
            <div style="margin-top:18px;">
                <a href="{{ $verify_url }}" style="display:inline-block;background-color:#10b981;color:#ffffff;text-decoration:none;padding:12px 16px;border-radius:12px;font-weight:800;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;">
                    Verify & Continue
                </a>
            </div>
        @endif

        @if(!empty($email))
            <div style="margin-top:10px;color:#64748b;">
                Requested for: <span style="font-weight:800;color:#0f172a;">{{ $email }}</span>
            </div>
        @endif

        <div style="margin-top:16px;color:#94a3b8;font-size:12px;">
            Do not share this code with anyone.
        </div>
    </div>
@endsection
