@extends('layouts.auth')

@section('title', 'Forgot Password')
@section('content')
@include('components.loading')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Forgot Password</h3>
            </div>
            <div class="card-body">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form id="forgot-password-form"  method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="name@example.com">
                        <label for="email">Email Address</label>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("forgot-password-form");
            const loadingOverlay = document.getElementById("loading");
            const submitButton = form.querySelector("button[type='submit']");

            if (form && loadingOverlay && submitButton) {
                form.addEventListener("submit", function (e) {
                    loadingOverlay.style.display = "flex";
                    submitButton.disabled = true;
                    submitButton.textContent = "Loading...";
                });
            } else {
                console.error("Form, loading overlay, atau tombol submit tidak ditemukan!");
            }
        });
    </script>
@endpush
@endsection
