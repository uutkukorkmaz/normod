<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RespondWithJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->add([
            'Accept' => 'application/json'
        ]);

        return $next($request)->header(
            'Content-Type',
            'application/json; vendor=' . Str::slug(config('app.company')) . '.' . Str::slug(config('app.name'))
        );
    }
}
