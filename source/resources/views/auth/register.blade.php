@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-flex">
                <div class="auth-side w-100">
                    <h2 class="fw-bold">Mulai petualanganmu</h2>
                    <p class="opacity-75">Buat akun wisatawan dan temukan ratusan tempat menarik di seluruh Indonesia.</p>
                    <ul class="list-unstyled small opacity-75 mt-3">
                        <li class="mb-2"><i class="fa-solid fa-circle-check me-2"></i>Simpan destinasi favorit</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-check me-2"></i>Tulis ulasan & rating</li>
                        <li><i class="fa-solid fa-circle-check me-2"></i>Pendaftaran cepat</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="auth-form">
                    <h3 class="fw-bold mb-1">Daftar Wisatawan</h3>
                    <p class="text-secondary mb-4">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk</a></p>

                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">No. HP <small class="text-secondary">(opsional)</small></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Ulangi password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg w-100 rounded-pill">Buat Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
