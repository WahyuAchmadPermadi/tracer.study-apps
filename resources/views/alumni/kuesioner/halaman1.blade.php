@extends('layouts.alumni')

@section('title', 'Tracer Study')

@section('content')

<div class="form-wrapper">

    <div class="card shadow-lg">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-2">
                Identitas Alumni
            </h3>

            <p class="text-muted">
                Silakan lengkapi identitas Anda.
            </p>

            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="width:12.5%">
                    1 / 8
                </div>
            </div>

            <form method="POST" action="{{ route('kuesioner.halaman1.simpan') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Kode PT
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="111022"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Program Studi
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $alumni->program_studi }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        NIM
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $alumni->nim }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $alumni->nama }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        value="{{ $alumni->email }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Tahun Lulus
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $alumni->tahun_lulus }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nomor WhatsApp <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        class="form-control @error('whatsapp') is-invalid @enderror"
                        name="whatsapp"
                        value="{{ old('whatsapp', $jawaban->whatsapp) }}"
                        required>

                    @error('whatsapp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        NIK <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        class="form-control @error('nik') is-invalid @enderror"
                        name="nik"
                        maxlength="16"
                        value="{{ old('nik', $jawaban->nik) }}"
                        required>

                    @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        NPWP
                        <span class="text-muted fw-normal">(Opsional)</span>
                    </label>

                    <input type="text"
                        name="npwp"
                        class="form-control"
                        value="{{ old('npwp', $alumni->npwp ?? '') }}">

                    @error('npwp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4">
                        Selanjutnya →
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection