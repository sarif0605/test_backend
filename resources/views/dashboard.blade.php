@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <!-- Main Header Section -->
    <div class="bg-primary text-white p-4 mb-4 rounded-3 mt-3 text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h6 class="text-uppercase">PEMROGRAMAN</h6>
                <h2>Pemrograman Frontend Modern dengan React dan Angular</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <div class="me-4">
                        <i class="fas fa-user me-2"></i> Pemateri By {{ auth()->user()->name }}
                    </div>
                    <div>
                        <i class="fas fa-calendar me-2"></i> {{ now() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h4 class="mb-4">INFORMASI CONTENT</h4>
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Perkembangan Content Perbulan
                </div>
                <div class="card-body">
                    <canvas id="chartContent"></canvas>
                </div>
            </div>
        </div>

        <!-- Kotak Informasi -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Konten yang Ditulis Bulan Ini</h5>
                    <p class="card-text">Informasi mengenai konten yang dibuat pada bulan {{ \Carbon\Carbon::now()->format('F Y') }}.</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="text-5xl font-bold text-white">{{ $contentThisMonth }} konten</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar & New Content Section -->
    <div class="row">
        <div class="col-md-8">
            <h4 class="mb-4">CONTENT TERBARU</h4>
            <div class="row">
                @forelse($images as $index => $content)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card bg-{{ $index == 0 ? 'dark' : ($index == 1 ? 'danger' : 'warning') }} text-white">
                                <div class="card-body p-3">
                                    <h5>{{ $content->title ?? 'KONTEN' }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ $content->image_url }}" alt="{{ $content->title }}" class="img-fluid mb-3">
                                <h6 class="mb-3">MATERI KOMPETENSI</h6>
                                <p class="small mb-2">{{ $content->description ?? 'Deskripsi konten' }}</p>
                                <p class="small text-muted mt-2">
                                    <i class="fas fa-calendar me-1"></i> {{ $content->created_at->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Programming CONTENTe (fallback if no images) -->
                    <div class="col-md-4 mb-4">
                        <h2>Belum Ada Content</h2>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Calendar Sidebar -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-3">SELAMAT DATANG, {{ auth()->user()->name }}</h5>
                    <p class="text-muted">Di LMS by Adhivasindo</p>

                    <!-- Calendar -->
                    <div class="card bg-dark text-white mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <button class="btn btn-sm btn-dark"><i class="fas fa-chevron-left"></i></button>
                                <h6 class="mb-0">{{ \Carbon\Carbon::now()->format('F Y') }}</h6>
                                <button class="btn btn-sm btn-dark"><i class="fas fa-chevron-right"></i></button>
                            </div>
                            <div class="calendar-grid">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="text-center" style="width: 14.28%">Su</div>
                                    <div class="text-center" style="width: 14.28%">Mo</div>
                                    <div class="text-center" style="width: 14.28%">Tu</div>
                                    <div class="text-center" style="width: 14.28%">We</div>
                                    <div class="text-center" style="width: 14.28%">Th</div>
                                    <div class="text-center" style="width: 14.28%">Fr</div>
                                    <div class="text-center" style="width: 14.28%">Sa</div>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="text-center" style="width: 14.28%">1</div>
                                    <div class="text-center" style="width: 14.28%">2</div>
                                    <div class="text-center" style="width: 14.28%">3</div>
                                    <div class="text-center bg-primary rounded" style="width: 14.28%">4</div>
                                    <div class="text-center" style="width: 14.28%">5</div>
                                    <div class="text-center" style="width: 14.28%">6</div>
                                    <div class="text-center" style="width: 14.28%">7</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("chartContent");
    if (ctx) {
        const myBarChart = new Chart(ctx.getContext("2d"), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: "Content",
                    backgroundColor: "rgba(78, 115, 223, 1)",
                    data: {!! json_encode($contentData) !!},
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: true
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            },
        });
    } else {
        console.error("Canvas element not found.");
    }
});
</script>
@endpush
@endsection