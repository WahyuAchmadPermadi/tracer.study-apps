@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')

<div class="card auth-card">

    <div class="card-body p-4 p-md-5">

        <div class="text-center mb-4">

            <img src="{{ asset('images/logo1.png') }}"
                class="auth-logo mb-3"
                alt="Logo UNU Kalbar">

            <h4 class="fw-bold mb-1">
                Login Admin
            </h4>

            <p class="text-muted mb-0">
                Sistem Tracer Study UNU Kalimantan Barat
            </p>

        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())

            <div class="alert alert-danger">

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        @endif

        <form method="POST"
            action="{{ url('/admin/login') }}">

            @csrf

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Username
                </label>

                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Password
                </label>

                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input id="admin-password" type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    <button
                        id="toggle-admin-password"
                        class="btn btn-outline-success"
                        type="button"
                        aria-label="Tampilkan password"
                        aria-pressed="false"
                        title="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

            </div>

            <button type="submit"
                    class="btn btn-success w-100">

                <i class="bi bi-box-arrow-in-right me-1"></i>
                Login

            </button>

        </form>

    </div>

</div>

<script>
    const passwordInput = document.getElementById('admin-password');
    const passwordToggle = document.getElementById('toggle-admin-password');

    passwordToggle.addEventListener('click', () => {
        const isPasswordHidden = passwordInput.type === 'password';
        const passwordIcon = passwordToggle.querySelector('i');

        passwordInput.type = isPasswordHidden ? 'text' : 'password';
        passwordIcon.classList.toggle('bi-eye', !isPasswordHidden);
        passwordIcon.classList.toggle('bi-eye-slash', isPasswordHidden);
        passwordToggle.setAttribute('aria-pressed', String(isPasswordHidden));
        passwordToggle.setAttribute('aria-label', isPasswordHidden ? 'Sembunyikan password' : 'Tampilkan password');
        passwordToggle.setAttribute('title', isPasswordHidden ? 'Sembunyikan password' : 'Tampilkan password');
    });
</script>

@endsection
