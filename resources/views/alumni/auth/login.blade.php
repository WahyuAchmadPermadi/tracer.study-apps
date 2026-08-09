@extends('layouts.alumni')

@section('title', 'Login Alumni')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
            
            <div class="card shadow-lg">

                <div class="card-body p-5">

                    {{-- Logo --}}
                    <div class="text-center mb-4">

                        <img src="{{ asset('images/logo1.png') }}"
                            alt="Logo UNU Kalbar"
                            width="95"
                            class="mb-3">

                        <h2 class="fw-bold text-success">
                            Login Alumni
                        </h2>

                        <p class="text-muted mb-0">
                            Silakan login menggunakan NIM dan Tanggal Lahir
                        </p>

                    </div>

                    {{-- Error Login --}}
                    @if($errors->has('login'))

                        <div class="alert alert-danger">

                            <i class="bi bi-exclamation-triangle-fill"></i>

                            {{ $errors->first('login') }}

                        </div>

                    @endif

                    {{-- Form Login --}}
                    <form method="POST"
                        action="{{ route('alumni.login.process') }}">

                        @csrf

                        {{-- NIM --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                NIM
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-person-badge"></i>

                                </span>

                                <input
                                    type="text"
                                    name="nim"
                                    class="form-control"
                                    placeholder="Masukkan NIM"
                                    value="{{ old('nim') }}"
                                    required>

                            </div>

                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Tanggal Lahir

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-calendar-event"></i>

                                </span>

                                <input
                                    type="date"
                                    name="tanggal_lahir"
                                    class="form-control"
                                    value="{{ old('tanggal_lahir') }}"
                                    required>

                            </div>

                        </div>

                        {{-- Tombol Login --}}
                        <div class="d-grid">

                            <button type="submit" class="btn btn-login">

                                <i class="bi bi-box-arrow-in-right me-2"></i>

                                Login

                            </button>

                        </div>

                    </form>

                    <hr class="my-4">

                    <div class="text-center text-muted">

                        <small>

                            © {{ date('Y') }} Tracer Study <br>

                            Universitas Nahdlatul Ulama Kalimantan Barat

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection