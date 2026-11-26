@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('heading', 'Edit Kategori')
@section('crumb')<a href="{{ route('admin.categories.index') }}">Kategori</a> / Edit @endsection

@section('content')
<div class="row">
    <div class="col-lg-5">
        <div class="card card-ad">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama kategori</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Ikon</label>
                        <select name="icon" class="form-select">
                            @foreach ($icons as $class => $label)
                                <option value="{{ $class }}" @selected(old('icon', $category->icon) === $class)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
