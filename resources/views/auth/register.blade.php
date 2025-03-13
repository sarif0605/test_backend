@extends('layouts.auth')

@section('title', 'Register')
@section('content')
@include('components.loading')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
            <div class="card-body">
                <form id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-floating mb-3">
                        <input class="form-control @error('name') is-invalid @enderror"
                               id="inputFirstName"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Enter your name"
                               required autofocus />
                        <label for="inputFirstName">Full Name</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror"
                               id="inputEmail"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="name@example.com"
                               required />
                        <label for="inputEmail">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password and Confirm Password -->
                    <div class="row mb-3">
                        <div class="col-md-6 position-relative">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control @error('password') is-invalid @enderror"
                                       id="inputPassword"
                                       type="password"
                                       name="password"
                                       placeholder="Create a password"
                                       required />
                                <label for="inputPassword">Password</label>
                                <span class="position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <div class="form-floating">
                                <input class="form-control"
                                       id="inputPasswordConfirm"
                                       type="password"
                                       name="password_confirmation"
                                       placeholder="Confirm password"
                                       required />
                                <label for="inputPasswordConfirm">Confirm Password</label>
                                <span class="position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;" id="togglePasswordConfirm">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("register-form");
            const loadingOverlay = document.getElementById("loading");
            const submitButton = form.querySelector("button[type='submit']");

            if (form && loadingOverlay && submitButton) {
                form.addEventListener("submit", function () {
                    loadingOverlay.style.display = "flex";
                    submitButton.disabled = true;
                    submitButton.textContent = "Loading...";
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.getElementById("togglePassword");
            const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");
            const passwordField = document.getElementById("inputPassword");
            const passwordConfirmField = document.getElementById("inputPasswordConfirm");

            togglePassword.addEventListener("click", function () {
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);
                this.innerHTML = type === "text" ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
            });

            togglePasswordConfirm.addEventListener("click", function () {
                const type = passwordConfirmField.getAttribute("type") === "password" ? "text" : "password";
                passwordConfirmField.setAttribute("type", type);
                this.innerHTML = type === "text" ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
            });
        });
    </script>
@endpush
@endsection
