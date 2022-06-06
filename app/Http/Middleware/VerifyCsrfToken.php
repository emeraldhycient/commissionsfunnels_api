<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/createaccount',
        '/api/login',
        '/api/products/create',
        '/api/products/update',
        '/api/products/delete',
        '/api/dispatchers/register',
        '/api/dispatchers/update',
        '/api/dispatchers/update/{company_id}',
        '/api/dispatchers/delete/{company_id}',
        '/api/vendors/register',
        '/api/vendors/update/{company_id}',
        '/api/vendors/delete/{company_id}'
    ];
}