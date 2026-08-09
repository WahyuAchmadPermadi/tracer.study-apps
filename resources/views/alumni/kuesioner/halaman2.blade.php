@extends('layouts.alumni')

@section('title','Tracer Study')

@section('content')

<div class="form-wrapper">

    <div class="card shadow-lg">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-2">
                Tracer Study Alumni
            </h3>

            <p class="text-muted">
                Halaman 2 dari 8
            </p>

            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="width:25%">
                    2 / 8
                </div>
            </div>

            <form method="POST" action="{{ route('kuesioner.halaman2.simpan') }}">

                @csrf

                {{-- Status Alumni --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Jelaskan status Anda saat ini.
                        <span class="text-danger">*</span>
                    </label>

                    @php
                        $status = old('status', $jawaban->status);
                    @endphp

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="status"
                            value="Bekerja (full time/part time)"
                            {{ $status == 'Bekerja (full time/part time)' ? 'checked' : '' }}
                            required>

                        <label class="form-check-label">
                            Bekerja (full time/part time)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="status"
                            value="Belum memungkinkan bekerja"
                            {{ $status == 'Belum memungkinkan bekerja' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Belum memungkinkan bekerja
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="status"
                            value="Wiraswasta"
                            {{ $status == 'Wiraswasta' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Wiraswasta
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="status"
                            value="Melanjutkan Pendidikan"
                            {{ $status == 'Melanjutkan Pendidikan' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Melanjutkan Pendidikan
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="status"
                            value="Tidak kerja tetapi sedang mencari kerja"
                            {{ $status == 'Tidak kerja tetapi sedang mencari kerja' ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Tidak kerja tetapi sedang mencari kerja
                        </label>
                    </div>

                    @error('status')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Mulai mencari kerja --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Kapan Anda mulai mencari pekerjaan?
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="month"
                        class="form-control @error('mulai_mencari_kerja') is-invalid @enderror"
                        name="mulai_mencari_kerja"
                        value="{{ old('mulai_mencari_kerja', $jawaban->mulai_mencari_kerja ? \Carbon\Carbon::parse($jawaban->mulai_mencari_kerja)->format('Y-m') : '') }}"
                        required>

                    @error('mulai_mencari_kerja')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Pekerjaan pertama --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Kapan Anda mendapatkan pekerjaan pertama?
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="month"
                        class="form-control @error('pekerjaan_pertama') is-invalid @enderror"
                        name="pekerjaan_pertama"
                        value="{{ old('pekerjaan_pertama', $jawaban->pekerjaan_pertama ? \Carbon\Carbon::parse($jawaban->pekerjaan_pertama)->format('Y-m') : '') }}"
                        required>

                    @error('pekerjaan_pertama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Pendapatan --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Berapa rata-rata pendapatan Anda per bulan?
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        class="form-control @error('pendapatan') is-invalid @enderror"
                        name="pendapatan"
                        placeholder="Contoh : 3500000"
                        value="{{ old('pendapatan', $jawaban->pendapatan) }}"
                        required>

                    @error('pendapatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex justify-content-between questionnaire-navigation">

                    <a href="{{ route('kuesioner.halaman1') }}"
                        class="btn btn-secondary">
                        ← Sebelumnya
                    </a>

                    <button type="submit" class="btn btn-success">
                        Selanjutnya →
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
