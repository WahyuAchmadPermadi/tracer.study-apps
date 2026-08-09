@extends('layouts.app')

@section('title', 'Reminder')

@section('content')

@php
    $jadwalAktif = (bool) old('is_active', $reminder->is_active);
    $tahunLulusTerpilih = old('tahun_lulus', $reminder->tahun_lulus);
@endphp

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Pengaturan Reminder</h5>
    </div>

    <div class="card-body">
        <form id="reminder-form"
            action="{{ $jadwalAktif ? route('reminder.update') : route('admin.reminder.send-now') }}"
            method="POST"
            data-update-url="{{ route('reminder.update') }}"
            data-send-now-url="{{ route('admin.reminder.send-now') }}">

            @csrf
            <input type="hidden" name="_method" value="PUT" id="reminder-method" @disabled(!$jadwalAktif)>

            <div class="mb-4">
                <label class="form-label fw-bold">Target Alumni</label>
                <select class="form-select" disabled>
                    <option>Semua alumni yang belum mengisi</option>
                </select>
                <div class="form-text">
                    Reminder hanya dikirim kepada alumni yang belum menyelesaikan kuesioner Tracer Study.
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <label for="tahun_lulus" class="form-label fw-bold">Tahun Lulus</label>
                    <select name="tahun_lulus" id="tahun_lulus" class="form-select @error('tahun_lulus') is-invalid @enderror">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunLulusOptions as $tahun)
                            <option value="{{ $tahun }}" @selected((string) $tahunLulusTerpilih === (string) $tahun)>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_lulus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8 mb-4">
                    <label class="form-label fw-bold d-block">Media Pengiriman</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="media" id="media_email" value="email" checked>
                        <label class="form-check-label" for="media_email">Email</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="media_whatsapp" disabled>
                        <label class="form-check-label text-muted" for="media_whatsapp">WhatsApp — Belum tersedia</label>
                    </div>
                    @error('media')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3 mb-4">
                <div>
                    <div class="fw-bold">Jadwal Pengiriman</div>
                    <small class="text-muted">Aktifkan untuk mengirim reminder secara otomatis.</small>
                </div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_active"
                        id="is_active" value="1" @checked($jadwalAktif)>
                    <label class="form-check-label" for="is_active" id="schedule-status">
                        {{ $jadwalAktif ? 'ON' : 'OFF' }}
                    </label>
                </div>
            </div>

            <div id="schedule-fields" class="row">
                <div class="col-md-4 mb-4">
                    <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', $reminder->start_date?->format('Y-m-d')) }}"
                        @disabled(!$jadwalAktif)>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-4">
                    <label for="send_time" class="form-label fw-bold">Jam Kirim</label>
                    <input type="time" name="send_time" id="send_time"
                        class="form-control @error('send_time') is-invalid @enderror"
                        value="{{ old('send_time', $reminder->send_time ? substr($reminder->send_time, 0, 5) : '') }}"
                        @disabled(!$jadwalAktif)>
                    @error('send_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-4">
                    <label for="frequency" class="form-label fw-bold">Frekuensi</label>
                    <select name="frequency" id="frequency" class="form-select @error('frequency') is-invalid @enderror" @disabled(!$jadwalAktif)>
                        <option value="daily" @selected(old('frequency', $reminder->frequency) === 'daily')>Harian</option>
                        <option value="weekly" @selected(old('frequency', $reminder->frequency) === 'weekly')>Mingguan</option>
                        <option value="monthly" @selected(old('frequency', $reminder->frequency) === 'monthly')>Bulanan</option>
                    </select>
                    @error('frequency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @error('is_active')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary" id="reminder-submit">
                <i class="bi {{ $jadwalAktif ? 'bi-save' : 'bi-send' }}"></i>
                <span id="reminder-submit-text">{{ $jadwalAktif ? 'Simpan Pengaturan' : 'Kirim Sekarang' }}</span>
            </button>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            Riwayat Pengaturan Reminder
        </h5>

        <form action="{{ route('reminder.setting-logs.clear') }}"
            method="POST"
            class="m-0"
            onsubmit="return confirm('Hapus seluruh riwayat pengaturan reminder?')">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Remove
            </button>
        </form>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Disimpan</th>
                        <th>Tanggal Mulai</th>
                        <th>Jam Kirim</th>
                        <th>Frekuensi</th>
                        <th>Tahun Lulus</th>
                        <th>Media</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($settingLogs as $log)

                    <tr>

                        <td class="text-center">
                            {{ $settingLogs->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $log->saved_at?->format('d-m-Y H:i') }}
                        </td>

                        <td>
                            {{ $log->start_date?->format('d-m-Y') ?? '-' }}
                        </td>

                        <td>
                            {{ $log->send_time }}
                        </td>

                        <td>
                            {{ ucfirst($log->frequency) }}
                        </td>

                        <td>
                            {{ $log->tahun_lulus ?? 'Semua Tahun' }}
                        </td>

                        <td>
                            {{ ucfirst($log->media) }}
                        </td>

                        <td>
                            @if($log->start_date && $log->send_time && $log->frequency)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center text-muted py-4">

                            Belum ada riwayat pengaturan reminder.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $settingLogs->links() }}
        </div>

    </div>

</div>

<div class="card shadow">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pengiriman</h5>

        <form action="{{ route('reminder.logs.clear') }}"
            method="POST"
            class="m-0"
            onsubmit="return confirm('Hapus seluruh riwayat pengiriman reminder?')">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Remove
            </button>
        </form>
    </div>

    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div class="btn-group" role="group" aria-label="Filter status riwayat">
                <a href="{{ route('reminder.index', array_filter(['search' => $search])) }}"
                    class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-outline-primary' }}">Semua</a>
                <a href="{{ route('reminder.index', array_filter(['status' => 'sent', 'search' => $search])) }}"
                    class="btn btn-sm {{ $status === 'sent' ? 'btn-success' : 'btn-outline-success' }}">Terkirim</a>
                <a href="{{ route('reminder.index', array_filter(['status' => 'failed', 'search' => $search])) }}"
                    class="btn btn-sm {{ $status === 'failed' ? 'btn-danger' : 'btn-outline-danger' }}">Gagal</a>
            </div>

            <form action="{{ route('reminder.index') }}" method="GET" class="w-100" style="max-width: 420px;">
                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <div class="input-group">
                    <input type="search" name="search" value="{{ $search }}" class="form-control"
                        placeholder="Cari NIM atau nama alumni..." aria-label="Cari NIM atau nama alumni">
                    <button type="submit" class="btn btn-primary" title="Cari" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th>Tanggal/Waktu</th>
                        <th>NIM</th>
                        <th>Nama Alumni</th>
                        <th>Media</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-center">{{ $logs->firstItem() + $loop->index }}</td>
                            <td>{{ $log->sent_at?->format('d-m-Y H:i') ?? '-' }}</td>
                            <td>{{ $log->nim }}</td>
                            <td>{{ $log->nama_alumni ?: ($log->alumni->nama ?? '-') }}</td>
                            <td>{{ ucfirst($log->media) }}</td>
                            <td>
                                <span class="badge {{ $log->status === 'sent' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $log->status === 'sent' ? 'Terkirim' : 'Gagal' }}
                                </span>
                            </td>
                            <td>{{ $log->status === 'sent' ? 'Berhasil' : ($log->error_message ?: 'Pengiriman gagal.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada riwayat pengiriman reminder.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $logs->links() }}</div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('reminder-form');
        const switchInput = document.getElementById('is_active');
        const scheduleFields = document.getElementById('schedule-fields');
        const scheduleInputs = scheduleFields.querySelectorAll('input, select');
        const methodInput = document.getElementById('reminder-method');
        const statusLabel = document.getElementById('schedule-status');
        const submitButton = document.getElementById('reminder-submit');
        const submitText = document.getElementById('reminder-submit-text');

        function updateScheduleMode() {
            const active = switchInput.checked;

            scheduleFields.classList.toggle('d-none', !active);
            scheduleInputs.forEach(function (input) {
                input.disabled = !active;
            });

            methodInput.disabled = !active;
            form.action = active ? form.dataset.updateUrl : form.dataset.sendNowUrl;
            statusLabel.textContent = active ? 'ON' : 'OFF';
            submitText.textContent = active ? 'Simpan Pengaturan' : 'Kirim Sekarang';
            submitButton.querySelector('i').className = active ? 'bi bi-save' : 'bi bi-send';
        }

        switchInput.addEventListener('change', updateScheduleMode);

        form.addEventListener('submit', function () {
            submitButton.disabled = true;
        });

        updateScheduleMode();
    });
</script>

@endsection
