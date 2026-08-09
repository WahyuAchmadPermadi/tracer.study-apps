<?php

namespace App\Mail;

use App\Models\Alumni;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Alumni $alumni;

    public function __construct(Alumni $alumni)
    {
        $this->alumni = $alumni;
    }

    public function build()
    {
        return $this
            ->subject('Reminder Pengisian Tracer Study')
            ->view('emails.reminder', [
                'alumni' => $this->alumni,
                'loginUrl' => route('alumni.login'),
                'logoUrl' => $this->publicLogoUrl(),
            ]);
    }

    private function publicLogoUrl(): ?string
    {
        $logoUrl = url('/images/logo1.png');
        $host = strtolower((string) parse_url($logoUrl, PHP_URL_HOST));

        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
            return null;
        }

        return $logoUrl;
    }
}
