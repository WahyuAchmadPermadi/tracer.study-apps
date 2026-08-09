@extends('layouts.alumni')

@section('title', 'Dashboard Alumni')

@section('content')

<div class="form-wrapper">

    <div class="card shadow-lg">

        <div class="card-header bg-primary text-white py-4">

            <h2 class="mb-0 fw-bold">

                <i class="bi bi-person-badge me-2"></i>

                Dashboard Alumni

            </h2>

        </div>

        <div class="card-body p-4">

            @if(session('success'))

                <div class="alert alert-success">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    {{ session('success') }}

                </div>

            @endif

            <table class="table table-bordered align-middle">

                <tr>
                    <th width="35%">NIM</th>
                    <td>{{ $alumni->nim }}</td>
                </tr>

                <tr>
                    <th>Nama</th>
                    <td>{{ $alumni->nama }}</td>
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
                    <th>Email</th>
                    <td>{{ $alumni->email }}</td>
                </tr>

                <tr>
                    <th>No HP</th>
                    <td>{{ $alumni->no_hp }}</td>
                </tr>

            </table>

            <hr class="my-4">

            @if($respon)

                <div class="alert alert-success">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    Anda sudah mengisi kuesioner.

                </div>

            @else

                <div class="alert alert-warning">

                    <i class="bi bi-exclamation-triangle-fill me-2"></i>

                    Anda belum mengisi kuesioner.

                </div>

            @endif

            <div class="d-flex justify-content-end gap-2 flex-wrap mt-4">

                @if($respon)

                    <a href="{{ route('kuesioner.halaman8') }}"
                        class="btn btn-success">

                        <i class="bi bi-eye me-1"></i>

                        Lihat Jawaban

                    </a>

                @else

                    <a href="{{ route('kuesioner.halaman1') }}"
                        class="btn btn-primary">

                        <i class="bi bi-pencil-square me-1"></i>

                        Isi Kuesioner

                    </a>

                @endif

                <form action="{{ route('alumni.logout') }}"
                    method="POST">

                    @csrf

                    <button class="btn btn-danger">

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection