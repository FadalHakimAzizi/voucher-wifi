@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="col-md-6 mx-auto">
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
            <h2 class="mt-3 mb-1 fw-bold text-dark">Join Fenyxz</h2>
            <p class="text-muted">Create your account</p>
        </div>

        <!-- Form Register -->
        <form method="POST" action="{{ route('user.register') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-3 position-relative">
                <i class="fas fa-user input-icon"></i>
                <input type="text" 
                       name="name"
                       class="form-control py-3 @error('name') is-invalid @enderror"
                       placeholder="Full Name"
                       value="{{ old('name') }}"
                       required>
                @error('name')
                    <div class="invalid-feedback d-block mt-2">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3 position-relative">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" 
                       name="email"
                       class="form-control py-3 @error('email') is-invalid @enderror"
                       placeholder="Email"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <div class="invalid-feedback d-block mt-2">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 position-relative">
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

            <!-- Confirm Password -->
            <div class="mb-4 position-relative">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" 
                       name="password_confirmation"
                       class="form-control py-3" 
                       placeholder="Confirm Password"
                       required>
            </div>

            <!-- Submit Button -->
            <button class="auth-btn btn text-white w-100 mb-3">
                <i class="fas fa-user-plus me-2"></i> REGISTER
            </button>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0">Already have an account?</p>
                <a href="{{ route('user.login') }}" class="text-decoration-none fw-bold" style="color: var(--primary);">
                    Sign in here
                </a>
            </div>
        </form>
    </div>
</div>
@endsection