@php
    $isFav = auth()->check() && auth()->user()->favorites->contains('id', $destination->id);
@endphp
<div class="card dest-card">
    <div class="dest-img">
        <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" loading="lazy"
             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
        <span class="dest-badge"><i class="fa-solid {{ $destination->category->icon }} me-1"></i>{{ $destination->category->name }}</span>
        @if ($destination->is_featured)
            <span class="dest-featured"><i class="fa-solid fa-star me-1"></i>Unggulan</span>
        @endif

        @auth
            <form action="{{ route('favorites.toggle', $destination) }}" method="POST">
                @csrf
                <button type="submit" class="fav-btn {{ $isFav ? 'active' : '' }}" title="{{ $isFav ? 'Hapus dari favorit' : 'Simpan ke favorit' }}">
                    <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="fav-btn" title="Masuk untuk menyimpan favorit"><i class="fa-regular fa-heart"></i></a>
        @endauth
    </div>
    <div class="card-body p-3">
        <h5 class="card-title fw-semibold mb-1"><a href="{{ route('destinations.show', $destination) }}" class="stretched-link-title">{{ $destination->name }}</a></h5>
        <div class="dest-meta mb-2"><i class="fa-solid fa-location-dot me-1 text-danger"></i>{{ $destination->location_label }}</div>
        <p class="small text-secondary mb-3">{{ \Illuminate\Support\Str::limit($destination->description, 85) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <div class="small">
                @include('partials.stars', ['rating' => $destination->reviews_avg_rating])
                <span class="text-secondary ms-1">
                    {{ $destination->reviews_avg_rating ? number_format($destination->reviews_avg_rating, 1) : 'Baru' }}
                    @if ($destination->reviews_count) ({{ $destination->reviews_count }}) @endif
                </span>
            </div>
            <div class="price-tag">{{ $destination->ticket_label }}</div>
        </div>
    </div>
</div>
