@extends('layouts.admin')

@section('title', 'Destinasi Wisata')
@section('heading', 'Destinasi Wisata')
@section('crumb', 'Destinasi')

@section('actions')
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Tambah Destinasi</a>
@endsection

@section('content')
<div class="card card-ad">
    <div class="card-header"><i class="fa-solid fa-table"></i>Daftar Destinasi</div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / kota / provinsi..."></div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary flex-fill"><i class="fa-solid fa-magnifying-glass me-1"></i>Cari</button>
                <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
            <tr><th>Destinasi</th><th>Kategori</th><th>Tiket</th><th>Rating</th><th>Dilihat</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse ($destinations as $d)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $d->image_url }}" class="thumb" alt="" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                            <div>
                                <div class="fw-semibold">{{ $d->name }}</div>
                                <small class="text-secondary"><i class="fa-solid fa-location-dot me-1"></i>{{ $d->location_label }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border"><i class="fa-solid {{ $d->category->icon }} me-1"></i>{{ $d->category->name }}</span></td>
                    <td>{{ $d->ticket_label }}</td>
                    <td>
                        @if ($d->reviews_avg_rating)
                            <i class="fa-solid fa-star text-warning"></i> {{ number_format($d->reviews_avg_rating, 1) }}
                            <small class="text-secondary">({{ $d->reviews_count }})</small>
                        @else
                            <span class="text-secondary">-</span>
                        @endif
                    </td>
                    <td>{{ number_format($d->views) }}</td>
                    <td>@if ($d->is_featured)<span class="badge text-bg-warning">Unggulan</span>@else<span class="badge text-bg-light border">Biasa</span>@endif</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('destinations.show', $d->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat di website"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.destinations.edit', $d) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.destinations.destroy', $d) }}" method="POST" class="d-inline" data-confirm="Hapus destinasi {{ $d->name }}? Semua ulasannya ikut terhapus.">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">Belum ada destinasi. <a href="{{ route('admin.destinations.create') }}">Tambah sekarang</a></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($destinations->hasPages())
        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-secondary">Menampilkan {{ $destinations->firstItem() }}-{{ $destinations->lastItem() }} dari {{ $destinations->total() }}</small>
            {{ $destinations->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
