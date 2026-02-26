<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light only">
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="width:100%;background-color:#f3f4f6;">
    <tr>
        <td align="center" style="padding:32px 12px;">
            <table role="presentation" width="640" cellpadding="0" cellspacing="0" style="width:640px;max-width:100%;background-color:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="padding:24px 28px;background:linear-gradient(90deg,#064e3b,#10b981);">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="middle" style="width:72px;">
                                    @if(!empty($logo_url))
                                        <img src="{{ $logo_url }}" alt="{{ $brand_name ?? config('app.name') }}" style="display:block;height:44px;width:auto;max-width:100%;">
                                    @endif
                                </td>
                                <td align="left" valign="middle" style="padding-left:14px;">
                                    <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:700;color:#ffffff;">
                                        {{ $brand_name ?? 'LAU Paradise Adventure' }}
                                    </div>
                                    @if(!empty($brand_tagline))
                                        <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:16px;font-weight:600;color:rgba(255,255,255,0.9);letter-spacing:0.12em;text-transform:uppercase;margin-top:6px;">
                                            {{ $brand_tagline }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:26px 28px 8px 28px;">
                        <div style="font-family:Arial,Helvetica,sans-serif;font-size:20px;line-height:26px;font-weight:800;color:#0f172a;">
                            {{ $heading ?? ($title ?? 'Notification') }}
                        </div>
                        @if(!empty($subheading))
                            <div style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:18px;font-weight:600;color:#64748b;margin-top:8px;">
                                {{ $subheading }}
                            </div>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 28px 8px 28px;">
                        @yield('content')
                    </td>
                </tr>

                @if(!empty($footer_note) || !empty($support_email) || !empty($support_phone) || !empty($support_whatsapp) || !empty($website_url))
                    <tr>
                        <td style="padding:18px 28px 26px 28px;border-top:1px solid #e5e7eb;background-color:#f8fafc;">
                            <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;color:#475569;">
                                @if(!empty($footer_note))
                                    <div style="margin-bottom:10px;">{{ $footer_note }}</div>
                                @endif

                                <div>
                                    @if(!empty($support_email))
                                        <span style="font-weight:700;color:#0f172a;">Email:</span>
                                        <a href="mailto:{{ $support_email }}" style="color:#065f46;text-decoration:none;">{{ $support_email }}</a>
                                    @endif
                                    @if(!empty($support_phone))
                                        <span style="margin:0 8px;color:#cbd5e1;">|</span>
                                        <span style="font-weight:700;color:#0f172a;">Phone:</span>
                                        <span style="color:#0f172a;">{{ $support_phone }}</span>
                                    @endif
                                    @if(!empty($support_whatsapp))
                                        <span style="margin:0 8px;color:#cbd5e1;">|</span>
                                        <span style="font-weight:700;color:#0f172a;">WhatsApp:</span>
                                        <span style="color:#0f172a;">{{ $support_whatsapp }}</span>
                                    @endif
                                    @if(!empty($website_url))
                                        <span style="margin:0 8px;color:#cbd5e1;">|</span>
                                        <span style="font-weight:700;color:#0f172a;">Website:</span>
                                        <a href="{{ $website_url }}" style="color:#065f46;text-decoration:none;">{{ $website_url }}</a>
                                    @endif
                                </div>

                                <div style="margin-top:10px;color:#94a3b8;">
                                    {{ $brand_name ?? config('app.name') }} &copy; {{ date('Y') }}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
</table>
</body>
</html>
