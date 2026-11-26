@php
    $editing = $destination->exists;
    $currentImage = $editing && $destination->image && \Illuminate\Support\Str::startsWith($destination->image, ['http://', 'https://']) ? $destination->image : '';
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ada isian yang perlu diperbaiki:</strong>
        <ul class="mb-0 mt-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ $editing ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($editing) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card card-ad">
                <div class="card-header"><i class="fa-solid fa-circle-info"></i>Informasi Destinasi</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama destinasi <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $destination->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih...</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('category_id', $destination->category_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota / Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="city" value="{{ old('city', $destination->city) }}" class="form-control @error('city') is-invalid @enderror" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="province" value="{{ old('province', $destination->province) }}" class="form-control @error('province') is-invalid @enderror" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat lengkap</label>
                            <input type="text" name="address" value="{{ old('address', $destination->address) }}" class="form-control @error('address') is-invalid @enderror">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $destination->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga tiket (Rp)</label>
                            <input type="number" min="0" name="ticket_price" value="{{ old('ticket_price', $destination->ticket_price) }}" class="form-control @error('ticket_price') is-invalid @enderror">
                            <div class="form-text">Isi 0 jika gratis.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jam buka</label>
                            <input type="text" name="open_hours" value="{{ old('open_hours', $destination->open_hours) }}" class="form-control" placeholder="08.00 - 17.00 WIB">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Fasilitas</label>
                            <textarea name="facilities" rows="3" class="form-control" placeholder="Satu fasilitas per baris, contoh:&#10;Parkir&#10;Toilet&#10;Musala">{{ old('facilities', $destination->facilities) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" value="{{ old('latitude', $destination->latitude) }}" class="form-control @error('latitude') is-invalid @enderror" placeholder="-7.6079">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" value="{{ old('longitude', $destination->longitude) }}" class="form-control @error('longitude') is-invalid @enderror" placeholder="110.2038">
                            <div class="form-text">Koordinat dipakai untuk menampilkan peta (klik kanan di Google Maps untuk menyalinnya).</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-ad mb-3">
                <div class="card-header"><i class="fa-solid fa-image"></i>Foto Destinasi</div>
                <div class="card-body">
                    <img id="imagePreview" src="{{ $destination->image_url }}" class="preview-box mb-3" alt="Preview" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">

                    <label class="form-label">Upload foto</label>
                    <input type="file" id="imageFile" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                    <div class="form-text mb-3">JPG, PNG, atau WEBP. Maks 3 MB.</div>

                    <label class="form-label">atau tempel link foto</label>
                    <input type="url" id="imageUrl" name="image_url" value="{{ old('image_url', $currentImage) }}" class="form-control @error('image_url') is-invalid @enderror" placeholder="https://...">
                    <div class="form-text">Jika upload & link diisi, yang dipakai adalah file upload.</div>
                </div>
            </div>

            <div class="card card-ad mb-3">
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $destination->is_featured))>
                        <label class="form-check-label fw-semibold" for="is_featured">Destinasi unggulan</label>
                    </div>
                    <small class="text-secondary">Tampil di bagian "Destinasi Unggulan" pada beranda.</small>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg"><i class="fa-solid fa-floppy-disk me-2"></i>{{ $editing ? 'Simpan Perubahan' : 'Simpan Destinasi' }}</button>
                <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
