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

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

@php
    $pageTitle = trim($__env->yieldContent('title'));
    $pageIcons = [
        'Dashboard' => 'bi-speedometer2',
        'Data Alumni' => 'bi-people-fill',
        'Jawaban Tracer' => 'bi-journal-check',
        'Reminder' => 'bi-bell-fill',
        'Laporan' => 'bi-file-earmark-bar-graph-fill',
        'Summary' => 'bi-pie-chart-fill',
        'Dashboard Summary' => 'bi-pie-chart-fill',
    ];
    $pageIcon = $pageIcons[$pageTitle] ?? 'bi-grid-1x2-fill';
@endphp

<body>

<div class="wrapper">

    <aside class="sidebar">

        @include('layouts.sidebar')

    </aside>

    <main class="main">
        <header class="page-header">
            <div>
                <h1 class="page-title"><i class="bi {{ $pageIcon }}"></i>{{ $pageTitle }}</h1>
                <p class="page-subtitle">
                    @if($pageTitle === 'Dashboard')
                        Selamat datang, {{ session('admin_nama') }}
                    @else
                        Sistem Informasi Tracer Study Universitas Nahdlatul Ulama Kalimantan Barat
                    @endif
                </p>
            </div>
            <button type="button" class="sidebar-toggle" id="sidebar-toggle" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>
        </header>

        <div class="page-content">
            @yield('content')
        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

<script>
    document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
        document.body.classList.toggle('sidebar-open');
    });
</script>

</body>

</html>
