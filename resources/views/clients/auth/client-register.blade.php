@extends('layouts.loginclient')

@push('styles')
<style>

        :root {
        --primary: #1e3a8a;
        --secondary: #64748b;
    }

    body {
        background-image: url('/images/marjane-background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin: 0;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* rend le fond plus sombre */
        z-index: -1;
    }
    .register-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .register-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .register-title {
        color: var(--primary);
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .register-subtitle {
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

    .register-btn {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
    }

    .register-btn:hover {
        background-color: #0f2c60;
        transform: translateY(-2px);
    }

    .register-footer {
        text-align: center;
        margin-top: 1.5rem;
    }

    .register-link {
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
    }

    .register-link:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
    <div class="register-header">
        <i class="bi bi-person-plus-fill register-icon"></i>
        <h1 class="register-title">Marjan Holding</h1>
        <h3 class="register-subtitle">Register Client</h3>
    </div>

    <form method="POST" action="{{ route('clients.register') }}">
        @csrf

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-person-fill form-input-icon"></i>
                <input type="text" name="name" class="form-control" placeholder="Name" required autofocus>
            </div>
        </div>

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-envelope-fill form-input-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
        </div>

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-geo-alt-fill form-input-icon"></i>
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>
        </div>

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-telephone-fill form-input-icon"></i>
                <input type="text" name="phone" class="form-control" placeholder="Phone" required>
            </div>
        </div>

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-lock-fill form-input-icon"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
        </div>

        <div class="form-input-group">
            <div class="position-relative">
                <i class="bi bi-shield-lock-fill form-input-icon"></i>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            </div>
        </div>

        <button type="submit" class="register-btn mb-3">
            <i class="bi bi-person-check-fill me-2"></i> Register
        </button>

        <div class="register-footer">
            <span class="text-muted">Already have an account? </span>
            <a href="{{ route('clients.login') }}" class="register-link">Login</a>
        </div>
    </form>
@endsection
