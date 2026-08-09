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
                Halaman 3 dari 8
            </p>

            <div class="progress mb-4">

                <div class="progress-bar bg-success"
                    style="width:37.5%">

                    3 / 8

                </div>

            </div>

            <form method="POST"
                action="{{ route('kuesioner.halaman3.simpan') }}">

                @csrf

                {{-- Jenis Perusahaan --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Apa jenis perusahaan / instansi / institusi tempat Anda bekerja saat ini?
                        <span class="text-danger">*</span>

                    </label>

                    <select class="form-select @error('jenis_perusahaan') is-invalid @enderror"
                        name="jenis_perusahaan"
                        required>

                        <option value="">-- Pilih --</option>

                        <option value="Pemerintah"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'Pemerintah' ? 'selected' : '' }}>
                            Pemerintah
                        </option>

                        <option value="BUMN/BUMD"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'BUMN/BUMD' ? 'selected' : '' }}>
                            BUMN/BUMD
                        </option>

                        <option value="Institusi Pendidikan"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'Institusi Pendidikan' ? 'selected' : '' }}>
                            Institusi Pendidikan
                        </option>

                        <option value="Organisasi Non Profit / LSM"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'Organisasi Non Profit / LSM' ? 'selected' : '' }}>
                            Organisasi Non Profit / LSM
                        </option>

                        <option value="Perusahaan Swasta"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'Perusahaan Swasta' ? 'selected' : '' }}>
                            Perusahaan Swasta
                        </option>

                        <option value="Wiraswasta / Perusahaan Sendiri"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'Wiraswasta / Perusahaan Sendiri' ? 'selected' : '' }}>
                            Wiraswasta / Perusahaan Sendiri
                        </option>

                        <option value="Lainnya"
                            {{ old('jenis_perusahaan', $jawaban->jenis_perusahaan) == 'Lainnya' ? 'selected' : '' }}>
                            Lainnya
                        </option>

                    </select>

                    @error('jenis_perusahaan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Nama Perusahaan --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama Perusahaan / Instansi / Tempat Bekerja
                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        class="form-control @error('nama_perusahaan') is-invalid @enderror"
                        name="nama_perusahaan"
                        value="{{ old('nama_perusahaan', $jawaban->nama_perusahaan) }}"
                        required>

                    @error('nama_perusahaan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Jabatan --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Jabatan / Posisi Pekerjaan
                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        class="form-control @error('jabatan') is-invalid @enderror"
                        name="jabatan"
                        value="{{ old('jabatan', $jawaban->jabatan) }}"
                        required>

                    @error('jabatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Provinsi --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Provinsi Tempat Bekerja
                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        class="form-control @error('provinsi') is-invalid @enderror"
                        name="provinsi"
                        value="{{ old('provinsi', $jawaban->provinsi) }}"
                        required>

                    @error('provinsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Kabupaten --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Kabupaten / Kota Tempat Bekerja
                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        class="form-control @error('kabupaten') is-invalid @enderror"
                        name="kabupaten"
                        value="{{ old('kabupaten', $jawaban->kabupaten) }}"
                        required>

                    @error('kabupaten')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Tingkat Tempat Kerja --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Tingkat Tempat Kerja
                        <span class="text-danger">*</span>

                    </label>

                    <select class="form-select @error('tingkat_tempat_kerja') is-invalid @enderror"
                        name="tingkat_tempat_kerja"
                        required>

                        <option value="">-- Pilih --</option>

                        <option value="Lokal / Wilayah"
                            {{ old('tingkat_tempat_kerja', $jawaban->tingkat_tempat_kerja) == 'Lokal / Wilayah' ? 'selected' : '' }}>
                            Lokal / Wilayah
                        </option>

                        <option value="Nasional"
                            {{ old('tingkat_tempat_kerja', $jawaban->tingkat_tempat_kerja) == 'Nasional' ? 'selected' : '' }}>
                            Nasional
                        </option>

                        <option value="Multinasional / Internasional"
                            {{ old('tingkat_tempat_kerja', $jawaban->tingkat_tempat_kerja) == 'Multinasional / Internasional' ? 'selected' : '' }}>
                            Multinasional / Internasional
                        </option>

                    </select>

                    @error('tingkat_tempat_kerja')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex justify-content-between questionnaire-navigation">

                    <a href="{{ route('kuesioner.halaman2') }}"
                        class="btn btn-secondary">

                        ← Sebelumnya

                    </a>

                    <button type="submit"
                        class="btn btn-success">

                        Selanjutnya →

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
