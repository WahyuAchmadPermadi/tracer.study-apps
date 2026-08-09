<?php

namespace App\Services;

use App\Mail\ReminderMail;
use App\Models\Alumni;
use App\Models\Reminder;
use App\Models\ReminderLog;
use Illuminate\Support\Facades\Mail;

class ReminderService
{
    public function send(Reminder $reminder, string $source = 'manual'): array
    {
        $alumnis = Alumni::query()
            ->whereDoesntHave('jawabanTracer', function ($query) {
                $query->whereNotNull('submitted_at');
            })
            ->when($reminder->tahun_lulus, function ($query, $tahunLulus) {
                $query->where('tahun_lulus', $tahunLulus);
            })
            ->get();

        $summary = [
            'total' => $alumnis->count(),
            'sent' => 0,
            'failed' => 0,
        ];

        foreach ($alumnis as $alumni) {
            $message = "Reminder Pengisian Tracer Study untuk {$alumni->nama} ({$alumni->nim}).";
            $logData = [
                'reminder_id' => $reminder->exists ? $reminder->id : null,
                'nim' => $alumni->nim,
                'nama_alumni' => $alumni->nama,
                'media' => 'email',
                'source' => $source,
                'message' => $message,
                'sent_at' => now(),
            ];

            if (empty($alumni->email)) {
                ReminderLog::create([
                    ...$logData,
                    'status' => 'failed',
                    'error_message' => 'Email alumni tidak tersedia.',
                ]);

                $summary['failed']++;

                continue;
            }

            try {
                Mail::to($alumni->email)->send(new ReminderMail($alumni));

                ReminderLog::create([
                    ...$logData,
                    'status' => 'sent',
                    'error_message' => null,
                ]);

                $summary['sent']++;
            } catch (\Throwable $exception) {
                report($exception);

                ReminderLog::create([
                    ...$logData,
                    'status' => 'failed',
                    'error_message' => 'Pengiriman email gagal. Periksa konfigurasi mailer.',
                ]);

                $summary['failed']++;
            }
        }

        return $summary;
    }

    public function hasScheduledSendInCurrentPeriod(string $frequency): bool
    {
        $now = now();

        [$start, $end] = match ($frequency) {
            'weekly' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'monthly' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            default => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
        };

        return ReminderLog::query()
            ->where('source', 'scheduled')
            ->whereBetween('sent_at', [$start, $end])
            ->exists();
    }
}
