<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsClient
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()?->tipo === 'cliente', 403);

        return $next($request);
    }
}
