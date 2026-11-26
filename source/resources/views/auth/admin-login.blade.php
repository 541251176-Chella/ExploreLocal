<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin &middot; ExploreLocal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="admin-body">
<div class="admin-login">
    <div class="card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="d-inline-grid mb-3" style="width:60px;height:60px;border-radius:16px;place-items:center;background:linear-gradient(135deg,#0d9488,#14b8a6);color:#fff;font-size:1.6rem"><i class="fa-solid fa-compass"></i></div>
                <h4 class="fw-bold mb-0">ExploreLocal Admin</h4>
                <small class="text-secondary">Masuk untuk mengelola konten website</small>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <button class="btn btn-primary w-100 py-2">Masuk ke Dashboard</button>
            </form>

            <div class="text-center mt-4"><a href="{{ route('home') }}" class="small text-decoration-none text-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Kembali ke website</a></div>
        </div>
    </div>
</div>
</body>
</html>
