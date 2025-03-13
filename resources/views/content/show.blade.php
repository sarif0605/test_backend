@extends('layouts.admin')

@section('title', 'Content Detail')

@section('content')
    <hr />

    <div class="d-flex justify-content-center mt-5">
        <div class="card shadow-lg border-0 w-75">
            <div class="card-body text-center">
                <!-- Title Section -->
                <h1 class="fw-bold text-primary mb-4">Title : {{ $content->title }}</h1>
                <h2 class="fw-bold text-primary mb-4">Category : {{ $content->category->title }}</h2>

                <!-- Image Section -->
                <div class="d-flex justify-content-center mb-4">
                    @if($content->image_url)
                        <img src="{{ $content->image_url }}" alt="Content Image" class="img-fluid rounded shadow-sm border" style="max-width: 70%; max-height: 350px; object-fit: cover;">
                    @else
                        <p class="text-muted">No image available.</p>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="text-start p-3 bg-light border rounded shadow-sm">
                    <label class="form-label fw-bold"><i class="fas fa-align-left me-1"></i> Content</label>
                    <p class="mb-0">{{ $content->content }}</p>
                </div>

                <!-- Comment & Rating Section -->
                <div class="mt-5 text-start">
                    <h3 class="fw-bold text-secondary">
                        Comment & Rating ({{ $content->comments->count() }} Komentar)
                    </h3>

                    <!-- Rata-rata rating -->
                    <div class="mb-3">
                        <h5 class="fw-bold text-primary">Average Rating:
                            @php
                                $roundedRating = round($averageRating);
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= $roundedRating)
                                    <i class="fas fa-star text-warning"></i> <!-- Bintang Penuh -->
                                @else
                                    <i class="far fa-star text-warning"></i> <!-- Bintang Kosong -->
                                @endif
                            @endfor
                            ({{ number_format($averageRating, 1) }})
                        </h5>
                    </div>

                    <div class="p-3 bg-white border rounded shadow-sm">
                        @if($content->comments->isEmpty())
                            <p class="text-muted">No comments available.</p>
                        @else
                            @foreach($content->comments as $comment)
                                <div class="border-bottom pb-2 mb-3">
                                    <!-- User Name -->
                                    <h5 class="fw-bold text-primary mb-1">
                                        {{ $comment->user->name ?? 'Anonymous' }}
                                    </h5>

                                    <!-- Rating dari masing-masing komentar -->
                                    <div class="mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if($i <= $comment->rating)
                                                <i class="fas fa-star text-warning"></i> <!-- Bintang Penuh -->
                                            @else
                                                <i class="far fa-star text-warning"></i> <!-- Bintang Kosong -->
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Comment Content -->
                                    <p class="mb-0">{{ $comment->comment }}</p>
                                    <small class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-4">
                    <a href="{{ route('content') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
