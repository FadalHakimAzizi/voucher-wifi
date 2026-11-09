@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="col-md-5 mx-auto">
    <div class="auth-card p-4 p-md-5 position-relative">
        <!-- Logo Brand -->
        <div class="text-center mb-4">
            <svg class="brand-logo" width="80" height="80" viewBox="0 0 24 24" fill="url(#gradient)">
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#6366f1"/>
                    <stop offset="100%" style="stop-color:#ec4899"/>
                </linearGradient>
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
            <h2 class="mt-3 mb-1 fw-bold text-dark">Fenyxz WiFi</h2>
            <p class="text-muted">Login to your account</p>
        </div>

        <!-- Form Login -->
        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3 position-relative">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" 
                       name="email"
                       class="form-control py-3 @error('email') is-invalid @enderror"
                       placeholder="Email"
                       value="{{ old('email') }}"
                       required autofocus>
                @error('email')
                    <div class="invalid-feedback d-block mt-2">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4 position-relative">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" 
                       name="password"
                       class="form-control py-3 @error('password') is-invalid @enderror" 
                       placeholder="Password"
                       required>
                @error('password')
                    <div class="invalid-feedback d-block mt-2">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button class="auth-btn btn text-white w-100 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i> SIGN IN
            </button>

            <!-- Register Link -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0">Don't have an account?</p>
                <a href="{{ route('user.register') }}" class="text-decoration-none fw-bold" style="color: var(--primary);">
                    Create an account
                </a>
            </div>
        </form>
    </div>
</div>
@endsection