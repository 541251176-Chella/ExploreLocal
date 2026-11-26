<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ExploreLocal') &middot; ExploreLocal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top el-navbar py-2">
    <div class="container">
        <a class="navbar-brand el-brand d-flex align-items-center" href="{{ route('home') }}">
            <span class="brand-icon"><i class="fa-solid fa-compass"></i></span>Explore<span>Local</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-lg-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}" href="{{ route('destinations.index') }}">Destinasi</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" href="{{ route('favorites.index') }}">Favorit Saya</a></li>
                @endauth
            </ul>
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Daftar</a>
                @else
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                            <span class="avatar-circle me-2">{{ auth()->user()->initial }}</span>
                            <span class="fw-medium">{{ \Illuminate\Support\Str::words(auth()->user()->name, 1, '') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            @if (auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-2 text-primary"></i>Dashboard Admin</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2 text-primary"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('favorites.index') }}"><i class="fa-solid fa-heart me-2 text-primary"></i>Favorit Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

@if (session('success') || session('error'))
    <div class="container mt-3">@include('partials.flash')</div>
@endif

@yield('content')

<footer class="el-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h5 class="text-white fw-bold"><i class="fa-solid fa-compass me-2 text-warning"></i>ExploreLocal</h5>
                <p class="mt-3 pe-lg-5">Temukan, simpan, dan ulas destinasi wisata lokal Indonesia. Dari pantai, gunung, hingga pasar tradisional, semuanya ada di satu tempat.</p>
            </div>
            <div class="col-6 col-lg-3">
                <h6>Jelajahi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('destinations.index') }}">Semua Destinasi</a></li>
                    <li class="mb-2"><a href="{{ route('register') }}">Daftar Wisatawan</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-4">
                <h6>Pengelola</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('admin.login') }}"><i class="fa-solid fa-lock me-2"></i>Login Admin</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center small">&copy; {{ date('Y') }} ExploreLocal. Dibuat dengan Laravel.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
