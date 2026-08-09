<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
            content="width=device-width, initial-scale=1">

    <title>@yield('title') | Tracer Study</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
            rel="stylesheet">

    <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet"
            href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>

<body class="alumni-page">

    {{-- Navbar tidak ditampilkan pada halaman login --}}
    @if (!request()->routeIs('alumni.login'))

        <nav class="navbar navbar-expand-lg">

            <div class="container">

                <a class="navbar-brand d-flex align-items-center"
                    href="{{ route('alumni.dashboard') }}">

                    <img src="{{ asset('images/logo1.png') }}"
                        alt="Logo UNU Kalbar"
                        class="logo img-fluid">

                    <div class="brand-text">

                        <strong>TRACER STUDY</strong>

                        <small class="d-block">
                            Universitas Nahdlatul Ulama Kalimantan Barat
                        </small>

                    </div>

                </a>

            </div>

        </nav>

    @endif


    <main class="{{ request()->routeIs('alumni.login') ? 'login-content' : 'content' }}">

        @yield('content')

    </main>


    @if (!request()->routeIs('alumni.login'))

        <footer>
            © {{ date('Y') }} Tracer Study -
            Universitas Nahdlatul Ulama Kalimantan Barat
        </footer>

    @endif


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>