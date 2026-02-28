@extends('emails.layout', [
    'title' => $subject ?? 'Password Reset',
    'heading' => $heading ?? 'Password Reset',
    'subheading' => $subheading ?? null,
    'brand_name' => $brand_name ?? 'LAU Paradise Adventure',
    'brand_tagline' => $brand_tagline ?? 'PARADISE ADVENTURE',
    'logo_url' => $logo_url ?? null,
    'website_url' => $website_url ?? null,
    'support_email' => $support_email ?? null,
    'support_phone' => $support_phone ?? null,
    'support_whatsapp' => $support_whatsapp ?? null,
    'footer_note' => $footer_note ?? 'If you did not request this change, please contact support immediately.'
])

@section('content')
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#0f172a;">
        <div style="margin-bottom:14px;font-weight:800;">
            Hello {{ $name ?? '' }},
        </div>

        <div style="margin-bottom:14px;">
            Your account password has been reset. Use the new password below to login.
        </div>

        <div style="font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:24px;font-weight:900;letter-spacing:0.12em;color:#064e3b;background-color:#ecfdf5;border:1px solid #a7f3d0;border-radius:14px;padding:14px 16px;text-align:center;">
            {{ $new_password ?? '' }}
        </div>

        @if(!empty($website_url))
            <div style="margin-top:16px;">
                <a href="{{ $website_url }}" style="display:inline-block;background:#10b981;color:#ffffff;text-decoration:none;font-weight:900;border-radius:14px;padding:12px 16px;">Login Now</a>
            </div>
        @endif

        @if(!empty($email))
            <div style="margin-top:16px;color:#64748b;font-size:12px;">
                Account: <span style="font-weight:800;color:#0f172a;">{{ $email }}</span>
            </div>
        @endif

        <div style="margin-top:16px;color:#94a3b8;font-size:12px;">
            For security, change this password immediately after you login.
        </div>
    </div>
@endsection
