@extends('layouts.admin')

@section('title', 'Wisatawan')
@section('heading', 'Data Wisatawan')
@section('crumb', 'Wisatawan')

@section('content')
<div class="card card-ad">
    <div class="card-header"><i class="fa-solid fa-users"></i>Wisatawan Terdaftar</div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-6"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau email..."></div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary flex-fill">Cari</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Nama</th><th>Email</th><th>No. HP</th><th>Favorit</th><th>Ulasan</th><th>Bergabung</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse ($users as $u)
                <tr>
                    <td><div class="d-flex align-items-center gap-2"><span class="avatar-sm d-inline-grid rounded-circle text-white fw-semibold" style="width:32px;height:32px;place-items:center;background:#0d9488">{{ $u->initial }}</span>{{ $u->name }}</div></td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone ?: '-' }}</td>
                    <td>{{ $u->favorites_count }}</td>
                    <td>{{ $u->reviews_count }}</td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" data-confirm="Hapus akun {{ $u->name }}? Ulasan dan favoritnya ikut terhapus.">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">Belum ada wisatawan terdaftar.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-secondary">Total {{ $users->total() }} wisatawan</small>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
