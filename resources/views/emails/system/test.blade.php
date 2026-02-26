@extends('emails.layout', [
    'title' => $subject ?? 'Email Test',
    'heading' => $heading ?? ($subject ?? 'Email Test'),
    'subheading' => $subheading ?? null,
    'brand_name' => $brand_name ?? 'LAU Paradise Adventure',
    'brand_tagline' => $brand_tagline ?? 'PARADISE ADVENTURE',
    'logo_url' => $logo_url ?? null,
    'website_url' => $website_url ?? null,
    'support_email' => $support_email ?? null,
    'support_phone' => $support_phone ?? null,
    'support_whatsapp' => $support_whatsapp ?? null,
    'footer_note' => $footer_note ?? 'If you did not request this email, you can safely ignore it.'
])

@section('content')
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#0f172a;">
        <div style="margin-bottom:14px;">
            {!! $body_html ?? '' !!}
        </div>

        @if(!empty($details) && is_array($details))
            <div style="margin-top:18px;margin-bottom:8px;font-size:12px;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:#64748b;">
                Details
            </div>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:separate;border-spacing:0;overflow:hidden;border-radius:14px;border:1px solid #e5e7eb;">
                @foreach($details as $label => $value)
                    <tr>
                        <td style="padding:12px 14px;background-color:#f8fafc;border-bottom:1px solid #e5e7eb;width:35%;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;font-weight:800;color:#0f172a;">
                            {{ $label }}
                        </td>
                        <td style="padding:12px 14px;background-color:#ffffff;border-bottom:1px solid #e5e7eb;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;font-weight:700;color:#334155;">
                            {{ is_scalar($value) ? $value : json_encode($value) }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if(!empty($cta_url) && !empty($cta_label))
            <div style="margin-top:20px;">
                <a href="{{ $cta_url }}" style="display:inline-block;background-color:#10b981;color:#ffffff;text-decoration:none;padding:12px 16px;border-radius:12px;font-weight:800;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;">
                    {{ $cta_label }}
                </a>
            </div>
        @endif
    </div>
@endsection
