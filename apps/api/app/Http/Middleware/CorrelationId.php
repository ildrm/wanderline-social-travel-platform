<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CorrelationId
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $correlationId = $this->resolveCorrelationId($request);

        $request->attributes->set('correlation_id', $correlationId);
        Context::add('correlation_id', $correlationId);

        $response = $next($request);
        $response->headers->set('X-Correlation-ID', $correlationId);

        return $response;
    }

    private function resolveCorrelationId(Request $request): string
    {
        $providedId = $request->header('X-Correlation-ID');

        if (is_string($providedId) && preg_match('/\A[A-Za-z0-9][A-Za-z0-9._-]{0,127}\z/', $providedId) === 1) {
            return $providedId;
        }

        return (string) Str::uuid();
    }
}
