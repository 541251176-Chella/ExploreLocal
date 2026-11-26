@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('actions')
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Tambah Destinasi</a>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card bg-c-primary">
            <div class="body">
                <div><div class="label">Total Destinasi</div><div class="value">{{ $stats['destinations'] }}</div></div>
                <i class="fa-solid fa-map-location-dot icon"></i>
            </div>
            <a href="{{ route('admin.destinations.index') }}" class="footer"><span>Lihat Detail</span><i class="fa-solid fa-angle-right"></i></a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card bg-c-success">
            <div class="body">
                <div><div class="label">Wisatawan</div><div class="value">{{ $stats['tourists'] }}</div></div>
                <i class="fa-solid fa-users icon"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="footer"><span>Lihat Detail</span><i class="fa-solid fa-angle-right"></i></a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card bg-c-warning">
            <div class="body">
                <div><div class="label">Ulasan</div><div class="value">{{ $stats['reviews'] }}</div></div>
                <i class="fa-solid fa-comments icon"></i>
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="footer"><span>Lihat Detail</span><i class="fa-solid fa-angle-right"></i></a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card bg-c-danger">
            <div class="body">
                <div><div class="label">Kategori</div><div class="value">{{ $stats['categories'] }}</div></div>
                <i class="fa-solid fa-tags icon"></i>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="footer"><span>Lihat Detail</span><i class="fa-solid fa-angle-right"></i></a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-7">
        <div class="card card-ad h-100">
            <div class="card-header"><i class="fa-solid fa-chart-area"></i>Aktivitas 14 Hari Terakhir</div>
            <div class="card-body"><div class="chart-box"><canvas id="areaChart"></canvas></div></div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-ad h-100">
            <div class="card-header"><i class="fa-solid fa-chart-column"></i>Destinasi per Kategori</div>
            <div class="card-body"><div class="chart-box"><canvas id="barChart"></canvas></div></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-7">
        <div class="card card-ad h-100">
            <div class="card-header d-flex justify-content-between"><span><i class="fa-solid fa-fire"></i>Destinasi Paling Banyak Dilihat</span>
                <a href="{{ route('admin.destinations.index') }}" class="small text-decoration-none">Semua</a></div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Destinasi</th><th>Kategori</th><th class="text-end">Dilihat</th></tr></thead>
                    <tbody>
                    @foreach ($topDestinations as $d)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $d->image_url }}" class="thumb" alt="" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                                    <div><div class="fw-semibold">{{ $d->name }}</div><small class="text-secondary">{{ $d->location_label }}</small></div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $d->category->name }}</span></td>
                            <td class="text-end fw-semibold">{{ number_format($d->views) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-ad h-100">
            <div class="card-header d-flex justify-content-between"><span><i class="fa-solid fa-comment-dots"></i>Ulasan Terbaru</span>
                <a href="{{ route('admin.reviews.index') }}" class="small text-decoration-none">Semua</a></div>
            <div class="list-group list-group-flush">
                @forelse ($latestReviews as $r)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $r->user->name }}</strong>
                            <span>@include('partials.stars', ['rating' => $r->rating])</span>
                        </div>
                        <small class="text-secondary d-block">di {{ $r->destination->name }} &middot; {{ $r->created_at->diffForHumans() }}</small>
                        <div class="small mt-1">{{ \Illuminate\Support\Str::limit($r->comment, 90) }}</div>
                    </div>
                @empty
                    <div class="list-group-item text-secondary text-center py-4">Belum ada ulasan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = "'Poppins', sans-serif";

    new Chart(document.getElementById('areaChart'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                { label: 'Wisatawan baru', data: @json($chartUsers), borderColor: '#0d9488', backgroundColor: 'rgba(13,148,136,.15)', fill: true, tension: .4, pointRadius: 3 },
                { label: 'Ulasan', data: @json($chartReviews), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.12)', fill: true, tension: .4, pointRadius: 3 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: @json($categoryLabels),
            datasets: [{ label: 'Jumlah destinasi', data: @json($categoryData), backgroundColor: '#0d9488', borderRadius: 6 }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, plugins: { legend: { display: false } } }
    });
</script>
@endpush
