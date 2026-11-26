@extends('layouts.app')

@section('title', 'Jelajahi Wisata Lokal Indonesia')

@section('content')
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <span class="hero-badge d-inline-block mb-3"><i class="fa-solid fa-earth-asia me-2"></i>Jelajahi Indonesia bersama ExploreLocal</span>
                <h1 class="display-4 fw-bold mb-3">Temukan Keindahan <span>Wisata Lokal</span> di Sekitarmu</h1>
                <p class="lead mb-4 opacity-75">Cari destinasi, simpan favoritmu, dan bagikan pengalaman perjalananmu bersama wisatawan lainnya.</p>

                <form action="{{ route('destinations.index') }}" method="GET" class="hero-search">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari destinasi atau kota...">
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select form-select-lg">
                                <option value="">Semua kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-primary btn-lg"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="stats-strip">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="stat-box"><div class="icon"><i class="fa-solid fa-map-location-dot"></i></div><div><h4>{{ $stats['destinations'] }}</h4><small>Destinasi wisata</small></div></div>
            </div>
            <div class="col-md-4">
                <div class="stat-box"><div class="icon"><i class="fa-solid fa-users"></i></div><div><h4>{{ $stats['tourists'] }}</h4><small>Wisatawan terdaftar</small></div></div>
            </div>
            <div class="col-md-4">
                <div class="stat-box"><div class="icon"><i class="fa-solid fa-comments"></i></div><div><h4>{{ $stats['reviews'] }}</h4><small>Ulasan pengunjung</small></div></div>
            </div>
        </div>
    </div>
</section>

<section class="section pb-2">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Jelajahi Berdasarkan Kategori</h2>
            <p class="section-sub">Pilih jenis wisata yang paling cocok dengan suasana hatimu.</p>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach ($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('destinations.index', ['category' => $category->id]) }}" class="cat-chip">
                        <i class="fa-solid {{ $category->icon }}"></i>
                        <div class="fw-semibold small">{{ $category->name }}</div>
                        <small>{{ $category->destinations_count }} tempat</small>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if ($featured->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-1">Destinasi Unggulan</h2>
                <p class="section-sub mb-0">Pilihan terbaik yang paling sering dikunjungi.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary rounded-pill d-none d-md-inline-block">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @foreach ($featured as $destination)
                <div class="col-md-6 col-lg-4">@include('partials.destination-card', ['destination' => $destination])</div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section pt-0">
    <div class="container">
        <div class="mb-4">
            <h2 class="section-title mb-1">Baru Ditambahkan</h2>
            <p class="section-sub mb-0">Destinasi terbaru dari tim ExploreLocal.</p>
        </div>
        <div class="row g-4">
            @foreach ($latest as $destination)
                <div class="col-md-6 col-lg-3">@include('partials.destination-card', ['destination' => $destination])</div>
            @endforeach
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="info-card h-100">
                    <div class="stat-box justify-content-center shadow-none p-0 mb-3"><div class="icon"><i class="fa-solid fa-heart"></i></div></div>
                    <h5>Simpan Favorit</h5>
                    <p class="text-secondary small mb-0">Daftar akun gratis, lalu simpan destinasi impianmu untuk dikunjungi nanti.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card h-100">
                    <div class="stat-box justify-content-center shadow-none p-0 mb-3"><div class="icon"><i class="fa-solid fa-star"></i></div></div>
                    <h5>Beri Ulasan</h5>
                    <p class="text-secondary small mb-0">Bagikan pengalamanmu supaya wisatawan lain bisa merencanakan perjalanan lebih baik.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card h-100">
                    <div class="stat-box justify-content-center shadow-none p-0 mb-3"><div class="icon"><i class="fa-solid fa-map"></i></div></div>
                    <h5>Info Lengkap</h5>
                    <p class="text-secondary small mb-0">Harga tiket, jam buka, fasilitas, dan peta lokasi tersedia di setiap destinasi.</p>
                </div>
            </div>
        </div>

        @guest
        <div class="rounded-4 p-5 mt-5 text-center text-white" style="background: linear-gradient(120deg, #0f766e, #0f172a)">
            <h3 class="fw-bold">Siap menjelajah?</h3>
            <p class="opacity-75">Buat akun wisatawan untuk menyimpan favorit dan menulis ulasan.</p>
            <a href="{{ route('register') }}" class="btn btn-accent btn-lg rounded-pill px-5">Daftar Sekarang</a>
        </div>
        @endguest
    </div>
</section>
@endsection
