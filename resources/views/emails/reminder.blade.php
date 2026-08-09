<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Pengisian Tracer Study</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: Arial, Helvetica, sans-serif; color: #343a40;">
    @php
        $logoSource = $logoUrl ?: $message->embed(public_path('images/logo1.png'));
    @endphp
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f6f9; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 640px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);">
                    <tr>
                        <td align="center" style="background-color: #0B5D3B; padding: 24px;">
                            <img src="{{ $logoSource }}" alt="Logo Universitas Nahdlatul Ulama Kalimantan Barat" width="68" style="display: block; width: 68px; max-width: 100%; height: auto; margin-bottom: 12px;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; line-height: 1.3;">Reminder Pengisian Tracer Study</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px; font-size: 16px; line-height: 1.65;">
                            <p style="margin: 0 0 16px;">Yth.</p>
                            <p style="margin: 0 0 22px; font-weight: 700;">{{ $alumni->nama }}</p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 0 24px; background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 12px 16px; width: 42%; font-weight: 700;">NIM</td>
                                    <td style="padding: 12px 16px;">{{ $alumni->nim }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; width: 42%; font-weight: 700; border-top: 1px solid #e9ecef;">Program Studi</td>
                                    <td style="padding: 12px 16px; border-top: 1px solid #e9ecef;">{{ $alumni->program_studi }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; width: 42%; font-weight: 700; border-top: 1px solid #e9ecef;">Tahun Lulus</td>
                                    <td style="padding: 12px 16px; border-top: 1px solid #e9ecef;">{{ $alumni->tahun_lulus }}</td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 16px;">Kami mengundang Saudara/i untuk mengisi Tracer Study Alumni Universitas Nahdlatul Ulama Kalimantan Barat.</p>
                            <p style="margin: 0 0 24px;">Partisipasi Anda sangat membantu dalam evaluasi dan peningkatan kualitas pendidikan.</p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto 28px;">
                                <tr>
                                    <td align="center" style="background-color: #0B5D3B; border-radius: 8px;">
                                        <a href="{{ $loginUrl }}" style="display: inline-block; padding: 13px 24px; color: #ffffff; font-size: 16px; font-weight: 700; text-decoration: none;">Isi Tracer Study</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f8f9fa; border-top: 1px solid #e9ecef; padding: 20px 32px; color: #6c757d; font-size: 13px; line-height: 1.6; text-align: center;">
                            <strong style="color: #343a40;">Universitas Nahdlatul Ulama Kalimantan Barat</strong><br>
                            Email ini dikirim otomatis oleh Sistem Tracer Study.<br>
                            Mohon tidak membalas email ini.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
