@extends('layouts.loginclient')

@section('title', 'Client Login')

@push('styles')
<style>
    /* Styles spécifiques au formulaire */
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .login-title {
        color: var(--primary);
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        color: var(--secondary);
        font-size: 1.25rem;
        font-weight: 500;
    }

    .form-input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
    }

    .form-control {
        padding-left: 40px;
        border: 2px solid var(--primary);
        border-radius: 6px;
        height: 45px;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.2);
    }

    .login-btn {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
    }

    .login-btn:hover {
        background-color: #0f2c60;
        transform: translateY(-2px);
    }

    .login-footer {
        text-align: center;
        margin-top: 1.5rem;
    }

    .login-link {
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
    }

    .login-link:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div>
    <div class="login-header">
        <i class="bi bi-person-circle login-icon"></i>
        <h1 class="login-title">Marjan Holding</h1>
        <h3 class="login-subtitle">Login Client</h3>
    </div>

    <form method="POST" action="{{ route('clients.login') }}">
        @csrf

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-envelope-fill form-input-icon"></i>
                <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Email">
            </div>
        </div>

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-lock-fill form-input-icon"></i>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
            </div>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('password.request') }}" class="login-link">Forgot Password?</a>
        </div>

        <button type="submit" class="login-btn mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i> Login
        </button>

        <div class="login-footer">
            <span class="text-muted">Don't have an account? </span>
            <a href="{{ route('clients.register') }}" class="login-link">Register</a>
        </div>
    </form>
</div>
@endsection
