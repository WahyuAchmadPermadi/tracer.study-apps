<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reminder;
use App\Services\ReminderService;

class SendReminderCommand extends Command
{
    protected $signature = 'reminder:send';

    protected $description = 'Mengirim reminder kepada alumni yang belum mengisi kuesioner';

    public function handle(ReminderService $reminderService): int
    {
        $reminder = Reminder::first();

        if (!$reminder || !$reminder->is_active) {

            $this->info('Reminder tidak aktif.');

            return self::SUCCESS;
        }

        if ($reminder->media !== 'email') {

            $this->info('Media bukan Email.');

            return self::SUCCESS;
        }

        if (!$reminder->start_date || now()->startOfDay()->lt($reminder->start_date->startOfDay())) {

            $this->info('Belum memasuki tanggal mulai reminder.');

            return self::SUCCESS;
        }

        $sekarang = now()->format('H:i');

        if ($sekarang != substr($reminder->send_time, 0, 5)) {

            $this->info('Belum waktu pengiriman.');

            return self::SUCCESS;
        }

        switch ($reminder->frequency) {

            case 'weekly':
                if (now()->dayOfWeek != 1) { // Senin
                    $this->info('Hari ini bukan jadwal mingguan.');
                    return self::SUCCESS;
                }
                break;

            case 'monthly':
                if (now()->day != 1) { // Tanggal 1
                    $this->info('Hari ini bukan jadwal bulanan.');
                    return self::SUCCESS;
                }
                break;

            case 'daily':
            default:
                // Kirim setiap hari
                break;
        }

        if ($reminderService->hasScheduledSendInCurrentPeriod($reminder->frequency)) {

            $this->info('Reminder terjadwal sudah diproses untuk periode ini.');

            return self::SUCCESS;
        }

        $summary = $reminderService->send($reminder, 'scheduled');

        $this->info("Reminder selesai diproses. {$summary['sent']} terkirim, {$summary['failed']} gagal.");

        return self::SUCCESS;
    }
}
