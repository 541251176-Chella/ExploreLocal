@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-flex">
                <div class="auth-side w-100">
                    <h2 class="fw-bold">Selamat datang kembali!</h2>
                    <p class="opacity-75">Masuk untuk menyimpan destinasi favorit dan menulis ulasan perjalananmu.</p>
                    <ul class="list-unstyled small opacity-75 mt-3">
                        <li class="mb-2"><i class="fa-solid fa-circle-check me-2"></i>Simpan destinasi favorit</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-check me-2"></i>Tulis ulasan & rating</li>
                        <li><i class="fa-solid fa-circle-check me-2"></i>Gratis selamanya</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="auth-form">
                    <h3 class="fw-bold mb-1">Masuk</h3>
                    <p class="text-secondary mb-4">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar di sini</a></p>

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="nama@email.com" required autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <button class="btn btn-primary btn-lg w-100 rounded-pill">Masuk</button>
                    </form>

                    <div class="text-center mt-4 small text-secondary">
                        Pengelola website? <a href="{{ route('admin.login') }}">Login Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
