@extends('layouts.app')

@section('title', 'Semua Destinasi')

@section('content')
<section class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-1">Semua Destinasi</h1>
        <p class="mb-0 opacity-75">Temukan tempat wisata yang cocok untuk liburanmu berikutnya.</p>
    </div>
</section>

<div class="container" style="margin-top:-1.8rem">
    <form method="GET" action="{{ route('destinations.index') }}" class="info-card p-3">
        <div class="row g-2">
            <div class="col-lg-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, kota, atau provinsi...">
            </div>
            <div class="col-md-4 col-lg-3">
                <select name="category" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-3">
                <select name="sort" class="form-select">
                    <option value="">Terbaru</option>
                    <option value="populer" @selected(request('sort') === 'populer')>Paling populer</option>
                    <option value="rating" @selected(request('sort') === 'rating')>Rating tertinggi</option>
                    <option value="termurah" @selected(request('sort') === 'termurah')>Tiket termurah</option>
                </select>
            </div>
            <div class="col-md-4 col-lg-2 d-grid">
                <button class="btn btn-primary"><i class="fa-solid fa-filter me-1"></i>Terapkan</button>
            </div>
        </div>
    </form>
</div>

<div class="container py-5">
    @if ($destinations->isEmpty())
        <div class="empty-state">
            <i class="fa-regular fa-face-frown d-block"></i>
            <h5>Destinasi tidak ditemukan</h5>
            <p>Coba kata kunci atau kategori yang lain.</p>
            <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary rounded-pill">Reset pencarian</a>
        </div>
    @else
        <p class="text-secondary mb-4">Menampilkan {{ $destinations->total() }} destinasi</p>
        <div class="row g-4">
            @foreach ($destinations as $destination)
                <div class="col-md-6 col-lg-4">@include('partials.destination-card', ['destination' => $destination])</div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">{{ $destinations->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
