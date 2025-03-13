@extends('layouts.auth')

@section('title', 'Login')
@section('content')
@include('components.loading')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
            <div class="card-body">
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror"
                               id="inputEmail"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="name@example.com"
                               required autofocus />
                        <label for="inputEmail">Email address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3 position-relative">
                        <input class="form-control @error('password') is-invalid @enderror"
                               id="inputPassword"
                               type="password"
                               name="password"
                               placeholder="Password"
                               required />
                        <label for="inputPassword">Password</label>
                        <button type="button" id="togglePassword" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-2">
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" />
                        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("login-form");
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

            // Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('inputPassword');
            const toggleIcon = document.getElementById('toggleIcon');

            togglePassword.addEventListener('click', function () {
                // Toggle password visibility
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle icon
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endpush
@endsection
