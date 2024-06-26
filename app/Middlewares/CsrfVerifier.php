<?php
namespace OfficeMe\Middlewares;

use Pecee\Http\Middleware\BaseCsrfVerifier;

class CsrfVerifier extends BaseCsrfVerifier
{
 
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected array $except = [
        '/api/*',
        '/webhook/*'
    ];

}