<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sadece POST, PUT veya DELETE isteklerini logla [cite: 4]
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            Log::info('HTTP İstek Logu:', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_id' => $request->user() ? $request->user()->id : 'Guest',
                'input' => $request->all(),
            ]);
        }

        return $next($request);
    }
}
