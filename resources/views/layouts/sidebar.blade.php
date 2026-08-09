{{-- =========================================
    HEADER
========================================= --}}

<div class="sidebar-header text-center">

    <img src="{{ asset('images/logo1.png') }}"
        class="logo mb-3"
        alt="Logo">

    <h5 class="fw-bold mb-1">

        TRACER STUDY

    </h5>

    <small>

        Universitas Nahdlatul Ulama<br>
        Kalimantan Barat

    </small>

</div>


<div class="menu-line"></div>

<div class="menu-title">

    MENU UTAMA

</div>


{{-- =========================================
    MENU
========================================= --}}

<nav class="menu">

    <a href="{{ url('/admin/dashboard') }}"
        class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">

        <i class="bi bi-speedometer2"></i>

        <span>Dashboard</span>

    </a>


    <a href="{{ route('alumni.index') }}"
        class="menu-item {{ request()->is('admin/alumni*') ? 'active' : '' }}">

        <i class="bi bi-people-fill"></i>

        <span>Data Alumni</span>

    </a>


    <a href="{{ route('admin.jawaban-tracer.index') }}"
    class="menu-item {{ request()->routeIs('admin.jawaban-tracer.*') ? 'active' : '' }}">

        <i class="bi bi-journal-check"></i>

        <span>Jawaban Tracer</span>

    </a>


    <a href="{{ route('reminder.index') }}"
        class="menu-item {{ request()->is('admin/reminder*') ? 'active' : '' }}">

        <i class="bi bi-bell-fill"></i>

        <span>Reminder</span>

    </a>


    <a href="{{ route('laporan.index') }}"
        class="menu-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">

        <i class="bi bi-file-earmark-bar-graph-fill"></i>

        <span>Laporan</span>

    </a>

    <a href="{{ route('summary.index') }}"
        class="menu-item {{ request()->is('admin/summary*') ? 'active' : '' }}">

        <i class="bi bi-pie-chart-fill"></i>

        <span>Summary</span>

    </a>

</nav>


{{-- =========================================
    LOGOUT
========================================= --}}

<div class="logout">

    <div class="menu-line mb-3"></div>

    <a href="/admin/logout"
        class="logout-btn">

        <i class="bi bi-box-arrow-right me-2"></i>

        Logout

    </a>

</div>

