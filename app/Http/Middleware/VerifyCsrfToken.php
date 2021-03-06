<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'comment/upvote',
        'attachment/upload',
        'collection/change',
        'user/notice',
        'user/letters/messages',
        'user/letters/send',
        'user/letters/remove',
    ];
}
