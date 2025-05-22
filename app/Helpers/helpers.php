<?php

use Illuminate\Support\Facades\Auth;

function isAdmin() {
    return Auth::check() && Auth::user()->role === 'admin';
}

function isClient() {
    return Auth::guard('client')->check();
}

function isUser() {
    return Auth::check() && Auth::user()->role === 'user';
}
