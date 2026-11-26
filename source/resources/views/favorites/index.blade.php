@extends('layouts.app')

@section('title', 'Favorit Saya')

@section('content')
<section class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-1"><i class="fa-solid fa-heart me-2 text-warning"></i>Favorit Saya</h1>
        <p class="mb-0 opacity-75">Destinasi yang kamu simpan untuk dikunjungi nanti.</p>
    </div>
</section>

<div class="container py-5">
    @if ($destinations->isEmpty())
        <div class="empty-state">
            <i class="fa-regular fa-heart d-block"></i>
            <h5>Belum ada favorit</h5>
            <p>Tekan ikon hati pada destinasi untuk menyimpannya di sini.</p>
            <a href="{{ route('destinations.index') }}" class="btn btn-primary rounded-pill px-4">Cari Destinasi</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($destinations as $destination)
                <div class="col-md-6 col-lg-4">@include('partials.destination-card', ['destination' => $destination])</div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">{{ $destinations->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
