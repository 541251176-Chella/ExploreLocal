<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &middot; Admin ExploreLocal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body">
<div id="wrapper">

    {{-- SIDEBAR --}}
    <nav id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <span class="logo"><i class="fa-solid fa-compass"></i></span>
            <span>ExploreLocal<small>Panel Admin</small></span>
        </a>

        <div class="heading">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <div class="heading">Konten Wisata</div>
        <a href="{{ route('admin.destinations.index') }}" class="nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
            <i class="fa-solid fa-map-location-dot"></i> Destinasi Wisata
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i> Kategori
        </a>

        <div class="heading">Pengguna</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Wisatawan
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fa-solid fa-comments"></i> Ulasan
        </a>

        <div class="heading">Lainnya</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-link">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Website
        </a>

        <div class="sidebar-footer">
            Masuk sebagai:
            <strong>{{ auth()->user()->name }}</strong>
        </div>
    </nav>

    {{-- CONTENT --}}
    <div id="content-wrapper">
        <header class="topbar">
            <button class="btn-toggle" id="sidebarToggle" type="button"><i class="fa-solid fa-bars"></i></button>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="me-2 d-none d-sm-inline text-end lh-sm">
                        <span class="d-block fw-semibold small">{{ auth()->user()->name }}</span>
                        <small class="text-secondary">Administrator</small>
                    </span>
                    <span class="avatar">{{ auth()->user()->initial }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-globe me-2 text-secondary"></i>Lihat Website</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="admin-main">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h1 class="h3 page-title">@yield('heading')</h1>
                @yield('actions')
            </div>
            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house me-1"></i>Dashboard</a>
                @hasSection('crumb') / @yield('crumb') @endif
            </div>

            @include('partials.flash')

            @yield('content')
        </main>

        <footer class="admin-footer">&copy; {{ date('Y') }} ExploreLocal &middot; Backoffice dibuat dengan Laravel</footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
