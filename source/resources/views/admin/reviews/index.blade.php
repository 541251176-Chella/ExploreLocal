@extends('layouts.admin')

@section('title', 'Ulasan')
@section('heading', 'Ulasan Pengunjung')
@section('crumb', 'Ulasan')

@section('content')
<div class="card card-ad">
    <div class="card-header"><i class="fa-solid fa-comments"></i>Semua Ulasan</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Wisatawan</th><th>Destinasi</th><th>Rating</th><th>Ulasan</th><th>Tanggal</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($reviews as $r)
                <tr>
                    <td class="fw-semibold">{{ $r->user->name }}</td>
                    <td><a href="{{ route('destinations.show', $r->destination->slug) }}" target="_blank" class="text-decoration-none">{{ $r->destination->name }}</a></td>
                    <td>@include('partials.stars', ['rating' => $r->rating])</td>
                    <td style="max-width: 340px">{{ \Illuminate\Support\Str::limit($r->comment, 110) }}</td>
                    <td class="text-nowrap">{{ $r->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.reviews.destroy', $r) }}" method="POST" class="d-inline" data-confirm="Hapus ulasan ini?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">Belum ada ulasan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($reviews->hasPages())
        <div class="card-footer bg-white">{{ $reviews->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
