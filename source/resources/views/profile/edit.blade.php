@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<section class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-1">Profil Saya</h1>
        <p class="mb-0 opacity-75">Kelola data akunmu.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="info-card text-center">
                <span class="avatar-circle mb-3" style="width:80px;height:80px;font-size:2rem">{{ $user->initial }}</span>
                <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                <p class="text-secondary small">{{ $user->email }}</p>
                <div class="row text-center mt-3">
                    <div class="col-6"><h4 class="mb-0">{{ $favoritesCount }}</h4><small class="text-secondary">Favorit</small></div>
                    <div class="col-6"><h4 class="mb-0">{{ $reviewsCount }}</h4><small class="text-secondary">Ulasan</small></div>
                </div>
                <small class="text-secondary d-block mt-3">Bergabung {{ $user->created_at->translatedFormat('d F Y') }}</small>
            </div>
        </div>
        <div class="col-lg-8">
            <form action="{{ route('profile.update') }}" method="POST" class="info-card">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                    </div>
                    <div class="col-12"><hr><h6 class="fw-semibold">Ganti password <small class="text-secondary fw-normal">(kosongkan jika tidak ingin mengganti)</small></h6></div>
                    <div class="col-md-6">
                        <label class="form-label">Password baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ulangi password baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <button class="btn btn-primary rounded-pill px-4 mt-4"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
