@extends('layouts.admin')

@section('title', 'Category Detail')

@section('content')
    <hr />

    <div class="d-flex justify-content-center mt-5">
        <div class="card shadow-lg border-0 w-75">
            <div class="card-body text-center">
                <!-- Title Section -->
                <h1 class="fw-bold text-primary mb-4">{{ $category->title }}</h2>

                <!-- Image Section -->
                <div class="d-flex justify-content-center mb-4">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="Content Image" class="img-fluid rounded shadow-sm border" style="max-width: 70%; max-height: 350px; object-fit: cover;">
                    @else
                        <p class="text-muted">No image available.</p>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="text-start p-3 bg-light border rounded shadow-sm">
                    <label class="form-label fw-bold"><i class="fas fa-align-left me-1"></i> Description</label>
                    <p class="mb-0">{{ $category->description }}</p>
                </div>

                <!-- Back Button -->
                <div class="mt-4">
                    <a href="{{ route('category') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
