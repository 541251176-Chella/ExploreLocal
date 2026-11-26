@extends('layouts.admin')

@section('title', 'Kategori')
@section('heading', 'Kategori Wisata')
@section('crumb', 'Kategori')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card card-ad">
            <div class="card-header"><i class="fa-solid fa-plus"></i>Tambah Kategori</div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama kategori</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ikon</label>
                        <select name="icon" class="form-select @error('icon') is-invalid @enderror">
                            @foreach ($icons as $class => $label)
                                <option value="{{ $class }}" @selected(old('icon') === $class)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-ad">
            <div class="card-header"><i class="fa-solid fa-table"></i>Daftar Kategori</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Ikon</th><th>Nama</th><th>Jumlah destinasi</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                    @foreach ($categories as $c)
                        <tr>
                            <td><span class="badge text-bg-light border fs-6"><i class="fa-solid {{ $c->icon }} text-primary"></i></span></td>
                            <td class="fw-semibold">{{ $c->name }}</td>
                            <td>{{ $c->destinations_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" class="d-inline" data-confirm="Hapus kategori {{ $c->name }}?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
