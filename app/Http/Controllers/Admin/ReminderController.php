<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Reminder;
use App\Models\ReminderLog;
use App\Models\ReminderSettingLog;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ReminderController extends Controller
{
    public function index()
    {
        $reminder = Reminder::first() ?? new Reminder($this->defaultReminderAttributes());
        $tahunLulusOptions = $this->tahunLulusOptions();
        $status = request('status');
        $search = trim((string) request('search', ''));

        if (!in_array($status, ['sent', 'failed'], true)) {
            $status = null;
        }

        $logs = ReminderLog::with('alumni')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nim', 'like', "%{$search}%")
                        ->orWhere('nama_alumni', 'like', "%{$search}%")
                        ->orWhereHas('alumni', function ($query) use ($search) {
                            $query->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('sent_at')
            ->paginate(10)
            ->withQueryString();

        $settingLogs = ReminderSettingLog::latest('saved_at')
            ->paginate(10, ['*'], 'setting_page');

        return view('admin.reminder.index', compact(
            'reminder',
            'tahunLulusOptions',
            'logs',
            'settingLogs',
            'status',
            'search'
        ));
    }

    public function update(Request $request)
    {
        if (!$request->boolean('is_active')) {
            return back()->withErrors([
                'is_active' => 'Aktifkan jadwal pengiriman untuk menyimpan pengaturan jadwal.',
            ])->withInput();
        }

        $data = $this->validatedReminderData($request, true);

        $reminder = Reminder::firstOrCreate([], $this->defaultReminderAttributes());

        $reminder->update($data);

        ReminderSettingLog::create([
            'reminder_id' => $reminder->id,
            'media' => $reminder->media,
            'frequency' => $reminder->frequency,
            'start_date' => $reminder->start_date,
            'send_time' => $reminder->send_time,
            'tahun_lulus' => $reminder->tahun_lulus,
            'message' => $reminder->message,
            'saved_at' => now(),
        ]);


        return redirect()
            ->route('reminder.index')
            ->with('success', 'Konfigurasi reminder berhasil disimpan.');
    }

    public function clearSettingLogs()
    {
        ReminderSettingLog::truncate();

        return redirect()
            ->route('reminder.index')
            ->with('success', 'Riwayat pengaturan reminder berhasil dihapus.');
    }

    public function clearLogs()
    {
        ReminderLog::truncate();

        return redirect()
            ->route('reminder.index')
            ->with('success', 'Riwayat pengiriman reminder berhasil dihapus.');
    }

    public function sendNow(Request $request, ReminderService $reminderService)
    {
        $data = $this->validatedReminderData($request, false);

        if ($request->boolean('is_active')) {
            return back()->withErrors([
                'is_active' => 'Matikan jadwal pengiriman untuk menggunakan Kirim Sekarang.',
            ])->withInput();
        }

        $reminder = Reminder::first() ?? new Reminder($this->defaultReminderAttributes());
        $reminder->fill($data);

        $summary = $reminderService->send($reminder, 'manual');

        if ($summary['total'] === 0) {
            return redirect()
                ->route('reminder.index')
                ->with('info', 'Tidak ada alumni yang memenuhi target reminder.');
        }

        return redirect()
            ->route('reminder.index')
            ->with('success', "Reminder selesai diproses. {$summary['sent']} terkirim, {$summary['failed']} gagal.");
    }

    private function validatedReminderData(Request $request, bool $isScheduled): array
    {
        $rules = [
            'media' => ['required', Rule::in(['email'])],
            'tahun_lulus' => ['nullable', Rule::in($this->tahunLulusOptions()->all())],
        ];

        if ($isScheduled) {
            $rules += [
                'start_date' => ['required', 'date'],
                'send_time' => ['required', 'date_format:H:i'],
                'frequency' => ['required', Rule::in(['daily', 'weekly', 'monthly'])],
            ];
        }

        $data = $request->validate($rules);

        return [
            'is_active' => $isScheduled,
            'media' => 'email',
            'tahun_lulus' => $data['tahun_lulus'] ?? null,
            'start_date' => $isScheduled ? $data['start_date'] : null,
            'send_time' => $isScheduled ? $data['send_time'] : null,
            'frequency' => $isScheduled ? $data['frequency'] : null,
            'message' => $this->fixedMessageSnapshot(),
        ];
    }

    private function tahunLulusOptions()
    {
        return Alumni::query()
            ->whereNotNull('tahun_lulus')
            ->distinct()
            ->orderByDesc('tahun_lulus')
            ->pluck('tahun_lulus');
    }

    private function defaultReminderAttributes(): array
    {
        return [
            'is_active' => false,
            'media' => 'email',
            'frequency' => 'weekly',
            'send_time' => '08:00:00',
            'message' => $this->fixedMessageSnapshot(),
        ];
    }

    private function fixedMessageSnapshot(): string
    {
        return 'Template tetap: Reminder Pengisian Tracer Study Alumni Universitas Nahdlatul Ulama Kalimantan Barat.';
    }
}
