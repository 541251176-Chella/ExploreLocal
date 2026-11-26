@extends('layouts.app')

@section('title', $destination->name)

@section('content')
@php
    $isFav = auth()->check() && auth()->user()->favorites->contains('id', $destination->id);
@endphp
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('destinations.index') }}">Destinasi</a></li>
            <li class="breadcrumb-item active">{{ $destination->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="detail-cover mb-4">
                <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}"
                     onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
            </div>

            <span class="badge bg-primary-soft rounded-pill px-3 py-2 mb-2"><i class="fa-solid {{ $destination->category->icon }} me-1"></i>{{ $destination->category->name }}</span>
            <h1 class="fw-bold">{{ $destination->name }}</h1>
            <div class="d-flex flex-wrap gap-3 text-secondary mb-4">
                <span><i class="fa-solid fa-location-dot text-danger me-1"></i>{{ $destination->location_label }}</span>
                <span>
                    @include('partials.stars', ['rating' => $destination->reviews_avg_rating, 'size' => '.9rem'])
                    <strong class="text-dark ms-1">{{ $destination->reviews_avg_rating ? number_format($destination->reviews_avg_rating, 1) : '-' }}</strong>
                    ({{ $destination->reviews_count }} ulasan)
                </span>
                <span><i class="fa-regular fa-eye me-1"></i>{{ number_format($destination->views) }} kali dilihat</span>
            </div>

            <h5 class="fw-semibold">Tentang Destinasi</h5>
            <p class="text-secondary" style="white-space: pre-line">{{ $destination->description }}</p>

            @if (count($destination->facility_list))
                <h5 class="fw-semibold mt-4">Fasilitas</h5>
                <div>
                    @foreach ($destination->facility_list as $facility)
                        <span class="facility-pill"><i class="fa-solid fa-check text-success me-1"></i>{{ $facility }}</span>
                    @endforeach
                </div>
            @endif

            @if ($destination->map_embed_url)
                <h5 class="fw-semibold mt-4">Lokasi</h5>
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                    <iframe src="{{ $destination->map_embed_url }}" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endif

            {{-- Ulasan --}}
            <div id="ulasan" class="mt-5">
                <h4 class="fw-bold mb-3">Ulasan Pengunjung ({{ $reviews->count() }})</h4>

                @auth
                    <form action="{{ route('reviews.store', $destination) }}" method="POST" class="info-card mb-4">
                        @csrf
                        <h6 class="fw-semibold">{{ $myReview ? 'Ubah ulasanmu' : 'Tulis ulasanmu' }}</h6>
                        <div class="star-input mb-2">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" @checked(old('rating', $myReview->rating ?? 0) == $i)>
                                <label for="star{{ $i }}" title="{{ $i }} bintang"><i class="fa-solid fa-star"></i></label>
                            @endfor
                        </div>
                        @error('rating') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                        <textarea name="comment" rows="3" class="form-control @error('comment') is-invalid @enderror" placeholder="Ceritakan pengalamanmu di sini...">{{ old('comment', $myReview->comment ?? '') }}</textarea>
                        @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <button class="btn btn-primary rounded-pill mt-3 px-4"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Ulasan</button>
                    </form>
                @else
                    <div class="info-card mb-4 text-center">
                        <p class="mb-2">Ingin berbagi pengalaman? Masuk dulu untuk menulis ulasan.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4">Daftar</a>
                    </div>
                @endauth

                @forelse ($reviews as $review)
                    <div class="review-item mb-3">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="avatar-circle">{{ $review->user->initial }}</span>
                                <div>
                                    <div class="fw-semibold">{{ $review->user->name }}</div>
                                    <small class="text-secondary">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                @include('partials.stars', ['rating' => $review->rating])
                                @auth
                                    @if (auth()->user()->isAdmin() || auth()->id() === $review->user_id)
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus ulasan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-link text-danger p-0 ms-2" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <p class="mt-2 mb-0 text-secondary">{{ $review->comment }}</p>
                    </div>
                @empty
                    <div class="empty-state py-4"><i class="fa-regular fa-comment-dots d-block"></i>Belum ada ulasan. Jadilah yang pertama!</div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar info --}}
        <div class="col-lg-4">
            <div class="info-card position-sticky" style="top: 90px">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <small class="text-secondary">Harga tiket</small>
                        <div class="fs-3 fw-bold text-primary">{{ $destination->ticket_label }}</div>
                    </div>
                    @auth
                        <form action="{{ route('favorites.toggle', $destination) }}" method="POST">
                            @csrf
                            <button class="btn {{ $isFav ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill">
                                <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart me-1"></i>{{ $isFav ? 'Favorit' : 'Simpan' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill"><i class="fa-regular fa-heart me-1"></i>Simpan</a>
                    @endauth
                </div>

                <div class="info-row">
                    <div class="ico"><i class="fa-regular fa-clock"></i></div>
                    <div><small class="text-secondary d-block">Jam buka</small><strong>{{ $destination->open_hours ?: 'Belum ada info' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="ico"><i class="fa-solid fa-location-dot"></i></div>
                    <div><small class="text-secondary d-block">Alamat</small><strong>{{ $destination->address ?: $destination->location_label }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="ico"><i class="fa-solid fa-tag"></i></div>
                    <div><small class="text-secondary d-block">Kategori</small><strong>{{ $destination->category->name }}</strong></div>
                </div>

                @if ($destination->latitude !== null && $destination->longitude !== null)
                    <a class="btn btn-primary w-100 rounded-pill mt-3" target="_blank" rel="noopener"
                       href="https://www.google.com/maps/search/?api=1&query={{ $destination->latitude }},{{ $destination->longitude }}">
                        <i class="fa-solid fa-diamond-turn-right me-2"></i>Buka di Google Maps
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if ($related->isNotEmpty())
        <h4 class="fw-bold mt-5 mb-3">Destinasi Serupa</h4>
        <div class="row g-4">
            @foreach ($related as $item)
                <div class="col-md-6 col-lg-4">@include('partials.destination-card', ['destination' => $item])</div>
            @endforeach
        </div>
    @endif
</div>
@endsection
