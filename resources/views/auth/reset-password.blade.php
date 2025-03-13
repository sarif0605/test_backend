@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
@include('components.loading')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header text-center">
                <h3 class="font-weight-bold my-3">Reset Password</h3>
            </div>
            <div class="card-body">
                <form id="reset-password-form" method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-group mb-3">
                        <label for="email" class="small mb-1">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" class="form-control py-2" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password" class="small mb-1">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control py-2" required autocomplete="new-password">
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                <i id="togglePasswordIcon" class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-4">
                        <label for="password_confirmation" class="small mb-1">{{ __('Confirm Password') }}</label>
                        <div class="input-group">
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control py-2" required autocomplete="new-password">
                            <button type="button" id="togglePasswordConfirm" class="btn btn-outline-secondary">
                                <i id="togglePasswordConfirmIcon" class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("reset-password-form");
            const loadingOverlay = document.getElementById("loading");
            const submitButton = form.querySelector("button[type='submit']");

            if (form && loadingOverlay && submitButton) {
                form.addEventListener("submit", function () {
                    loadingOverlay.style.display = "flex";
                    submitButton.disabled = true;
                    submitButton.textContent = "Loading...";
                });
            } else {
                console.error("Form, loading overlay, atau tombol submit tidak ditemukan!");
            }

            // Toggle Password Visibility
            function togglePasswordVisibility(buttonId, inputId, iconId) {
                const button = document.getElementById(buttonId);
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                button.addEventListener("click", function () {
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.replace("bi-eye", "bi-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.replace("bi-eye-slash", "bi-eye");
                    }
                });
            }

            togglePasswordVisibility("togglePassword", "password", "togglePasswordIcon");
            togglePasswordVisibility("togglePasswordConfirm", "password_confirmation", "togglePasswordConfirmIcon");
        });
    </script>
@endpush
@endsection
