@extends('layouts.admin')

@section('title', 'Category')
@section('content')
@include('components.loading')
<hr class="mb-3">
    @if(auth()->user()->role == 'admin')
    <div class="d-flex justify-content-between p-10 m-9">
        <a href="{{ route('category.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Add New Category
        </a>
    </div>
    @endif

    <hr class="mb-3" />
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Prospect Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0">Category Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mt-1" id="table-category" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('js')
        @include('category.script')
    @endpush

@endsection
