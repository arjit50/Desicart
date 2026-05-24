<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'register',                // registration form
        'login',                   // login form
        'checkout/*',              // checkout pages (index, store, success)
        'profile',                // profile routes without CSRF
        'profile/*',               // profile management routes
        'password',                // password routes without CSRF
        'logout',                    // logout route
    ];
}
