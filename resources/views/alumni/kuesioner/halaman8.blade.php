@extends('layouts.alumni')

@section('title','Review Kuesioner')

@section('content')

<div class="form-wrapper">

    <div class="card shadow-lg">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-2">
                Review Jawaban
            </h3>

            <p class="text-muted">
                Halaman 8 dari 8
            </p>

            <div class="progress mb-4">

                <div class="progress-bar bg-success"
                    style="width:100%">

                    8 / 8

                </div>

            </div>

            <div class="alert alert-success">

                <h5 class="mb-2">
                    Kuesioner hampir selesai.
                </h5>

                <p class="mb-0">
                    Silakan periksa kembali seluruh jawaban Anda.
                    Jika masih ada yang kurang tepat, klik tombol
                    <strong>Sebelumnya</strong> untuk melakukan perubahan.
                </p>

            </div>

            <div class="card border mb-4">

                <div class="card-header bg-light fw-bold">
                    Ringkasan Jawaban
                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tbody>

                            <tr>
                                <th width="35%">Nama Alumni</th>
                                <td>{{ $alumni->nama }}</td>
                            </tr>

                            <tr>
                                <th>NIM</th>
                                <td>{{ $alumni->nim }}</td>
                            </tr>

                            <tr>
                                <th>Program Studi</th>
                                <td>{{ $alumni->program_studi }}</td>
                            </tr>

                            <tr>
                                <th>Tahun Lulus</th>
                                <td>{{ $alumni->tahun_lulus }}</td>
                            </tr>

                            <tr>
                                <th>WhatsApp</th>
                                <td>{{ $jawaban->whatsapp ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Status Saat Ini</th>
                                <td>{{ $jawaban->status ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Jenis Perusahaan</th>
                                <td>{{ $jawaban->jenis_perusahaan ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Nama Perusahaan</th>
                                <td>{{ $jawaban->nama_perusahaan ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $jawaban->jabatan ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Studi Lanjut</th>
                                <td>{{ $jawaban->studi_lanjut ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Hubungan Bidang Studi</th>
                                <td>{{ $jawaban->hubungan_bidang ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Tingkat Pendidikan</th>
                                <td>{{ $jawaban->tingkat_pendidikan ?: '-' }}</td>
                            </tr>

                            <tr>
                                <th>Pendapatan</th>
                                <td>
                                    {{ $jawaban->pendapatan ? 'Rp '.number_format($jawaban->pendapatan,0,',','.') : '-' }}
                                </td>
                            </tr>

                        </tbody>

                    </table>

                    <p class="text-muted mb-0">
                        Ringkasan di atas hanya sebagai konfirmasi.
                        Seluruh jawaban akan dikirim setelah Anda menekan tombol
                        <strong>Kirim Kuesioner</strong>.
                    </p>

                </div>

            </div>

            <form method="POST" action="{{ route('kuesioner.submit') }}">
                @csrf

                <div class="form-check mb-4">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="setuju"
                        id="setuju"
                        value="1"
                        required>

                    <label class="form-check-label" for="setuju">
                        Saya menyatakan bahwa seluruh data yang saya isi adalah benar
                        dan dapat dipertanggungjawabkan.
                    </label>
                </div>

                <div class="d-flex justify-content-between questionnaire-navigation">

                    <a href="{{ route('kuesioner.halaman7') }}"
                    class="btn btn-secondary">
                        ← Sebelumnya
                    </a>

                    <button type="submit"
                            class="btn btn-success btn-lg">
                        Kirim Kuesioner
                    </button>

                </div>
            </form>

        </div>

    </div>

</div>

@endsection
