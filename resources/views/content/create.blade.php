@extends('layouts.admin')

@section('title', 'Tambah Content')

@section('content')
    @include('components.loading')

    <div class="container">
        <form id="content-form" class="p-4 card shadow-sm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header bg-primary text-white">
                <h4>Tambah Content</h4>
            </div>

            <div class="card-body">
                <!-- Judul -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Judul</label>
                    <input type="text" name="title" class="form-control" placeholder="Masukkan Judul" value="{{ old('title') }}">
                    @error('title')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Isi Content -->
                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">Isi</label>
                    <textarea id="editor" name="content" class="form-control" rows="8" placeholder="Tulis konten di sini">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">Kategori</label>
                    <select name="category_id" class="form-control">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $id => $title)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-3">
                    <label for="imageInput" class="form-label fw-bold">Gambar</label>
                    <input type="file" id="imageInput" name="image" class="form-control shadow-sm" accept="image/*">
                    @error('image')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preview Gambar -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Preview Gambar:</label>
                    <div id="imagePreview" class="d-flex flex-wrap gap-2"></div>
                </div>
            </div>

            <!-- Tombol Submit & Kembali -->
            <div class="card-footer text-center">
                <div class="row">
                    <div class="col-md-6 col-12 mb-2">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                    <div class="col-md-6 col-12">
                        <a href="{{ route('content') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("content-form");
            const loadingOverlay = document.getElementById("loading");
            const submitButton = form.querySelector("button[type='submit']");

            if (form && loadingOverlay && submitButton) {
                form.addEventListener("submit", function () {
                    loadingOverlay.style.display = "flex";
                    submitButton.disabled = true;
                    submitButton.innerHTML = "<i class='fas fa-spinner fa-spin'></i> Loading...";
                });
            }

            // Preview gambar sebelum upload
            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");

            if (imageInput && imagePreview) {
                imageInput.addEventListener("change", function (event) {
                    imagePreview.innerHTML = ""; // Hapus preview lama
                    const files = event.target.files;

                    for (let file of files) {
                        if (!file.type.startsWith("image/")) continue;

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = document.createElement("img");
                            img.src = e.target.result;
                            img.classList.add("img-thumbnail", "me-2", "mb-2");
                            img.style.width = "150px";
                            img.style.height = "150px";
                            img.style.objectFit = "cover";

                            imagePreview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
    @endpush
@endsection
