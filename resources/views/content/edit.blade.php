@extends('layouts.admin')

@section('title', 'Edit Content')

@section('content')
    <hr />
    @include('components.loading')

    <div class="container bg-white p-5 rounded-lg shadow-lg mx-auto">
        <div class="text-center mb-4">
            <h3 class="text-primary fw-bold">Edit Konten</h3>
        </div>

        <form id="survey-form-edit" action="{{ route('content.update', $content->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Input Title (Judul) -->
            <div class="mb-4">
                <label for="title" class="form-label fw-semibold">Judul</label>
                <input type="text" name="title" class="form-control shadow-sm border-primary" value="{{ old('title', $content->title) }}">
                @error('title')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Konten -->
            <div class="mb-4">
                <label for="content" class="form-label fw-semibold">Isi</label>
                <textarea class="form-control shadow-sm border-primary" name="content" rows="8">{{ old('content', $content->content) }}</textarea>
                @error('content')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-bold">Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($categories as $id => $title)
                        <option value="{{ $id }}" {{ old('category_id', $content->category_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Upload Gambar Baru -->
            <div class="mb-4">
                <label for="image" class="form-label fw-semibold">Upload Gambar Baru</label>
                <input type="file" id="imageInput" name="image" class="form-control shadow-sm border-primary" multiple accept="image/*">
                @error('image')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Gambar Sebelumnya -->
            <div class="mb-4 text-center">
                <label class="form-label fw-semibold">Gambar Sebelumnya</label>
                <div id="existingImages" class="d-flex justify-content-center">
                    <img src="{{ $content->image_url }}" alt="Existing Image" class="rounded shadow-sm border" style="max-width: 180px; max-height: 180px;">
                </div>
            </div>

            <!-- Preview Gambar Baru -->
            <div class="mb-4 text-center">
                <label class="form-label fw-semibold">Preview Gambar Baru</label>
                <div id="imagePreview" class="d-flex flex-wrap justify-content-center gap-2"></div>
            </div>

            <!-- Tombol -->
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-warning w-100 shadow-sm btn-lg">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('content') }}" class="btn btn-primary w-100 shadow-sm btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("survey-form-edit");
        const loadingOverlay = document.getElementById("loading");
        const submitButton = form.querySelector("button[type='submit']");

        if (form && loadingOverlay && submitButton) {
            form.addEventListener("submit", function () {
                loadingOverlay.style.display = "flex";
                submitButton.disabled = true;
                submitButton.innerHTML = "<i class='fas fa-spinner fa-spin'></i> Loading...";
            });
        } else {
            console.error("Form, loading overlay, atau tombol submit tidak ditemukan!");
        }
    });

    // Preview gambar baru
    document.getElementById('imageInput').addEventListener('change', function (event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = '';

        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (!file.type.startsWith('image/')) continue;

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'shadow-sm', 'border');
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';

                imagePreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

@endsection