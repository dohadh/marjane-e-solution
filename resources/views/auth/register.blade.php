@extends('layouts.auth')

@section('content')
<div class="royal-blue-login-container">
    <div class="royal-blue-login-box">
        <!-- Tête de profil comme icône -->
        <div class="profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#1E3A8A" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
            </svg>
        </div>

        <h1 class="royal-blue-title">Marjan Holding</h1>
        <h2 class="royal-blue-subtitle">Register Admin</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="royal-blue-form-group">
                <div class="input-with-icon">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1E3A8A" viewBox="0 0 16 16">
                        <path d="M0 4.5A4.5 4.5 0 1 1 9 4.5A4.5 4.5 0 0 1 0 4.5zM4 4.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0zM12 4.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0z"/>
                    </svg>
                    <input type="text" class="royal-blue-input" name="name" placeholder="Full Name" required>
                </div>
            </div>
                        <div class="royal-blue-form-group">
                <div class="input-with-icon">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1E3A8A" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                    </svg>
                    <input type="email" class="royal-blue-input" name="email" placeholder="Email" required autofocus>
                </div>
            </div>



            <div class="royal-blue-form-group">
                <div class="input-with-icon">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1E3A8A" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                    <input type="password" class="royal-blue-input" name="password" placeholder="Password" required>
                </div>
            </div>

            <div class="royal-blue-form-group">
                <div class="input-with-icon">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1E3A8A" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                    <input type="password" class="royal-blue-input" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
            </div>


            <button type="submit" class="royal-blue-login-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>
                Register
            </button>

            <div class="royal-blue-register-link">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Arial', sans-serif;
        box-sizing: border-box;
    }

    *, *:before, *:after {
        box-sizing: inherit;
    }

.royal-blue-login-container {
    /* Use your image URL here */
    background: 
        linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), /* dark overlay */
        url('/images/marjane-background.jpg') no-repeat center center / cover;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}
    .royal-blue-login-box {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
        position: relative;
        margin: 0 auto;
    }

    .profile-icon {
        margin-bottom: 15px;
    }

    .royal-blue-title {
        color: #1E3A8A;
        font-size: 28px;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .royal-blue-subtitle {
        color: #1E3A8A;
        font-size: 22px;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .royal-blue-form-group {
        margin-bottom: 20px;
        width: 100%;
    }

    .input-with-icon {
        position: relative;
        width: 100%;
    }

    .icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        z-index: 2;
    }

    .royal-blue-input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 2px solid #1E3A8A;
        border-radius: 6px;
        font-size: 16px;
        transition: all 0.3s;
        position: relative;
    }

    .royal-blue-input:focus {
        border-color: #1E3A8A;
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.2);
    }

    .royal-blue-login-btn {
        background-color: #1E3A8A;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
    }

    .royal-blue-login-btn:hover {
        background-color: #0f2c60;
        transform: translateY(-2px);
    }

    .royal-blue-register-link {
        margin-top: 20px;
        color: #1E3A8A;
        font-size: 14px;
        width: 100%;
        text-align: center;
    }

    .royal-blue-register-link a {
        color: #1E3A8A;
        font-weight: 500;
        text-decoration: none;
    }

    .royal-blue-register-link a:hover {
        text-decoration: underline;
    }
</style>
@endpush
