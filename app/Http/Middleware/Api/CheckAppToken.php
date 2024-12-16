<?php

namespace App\Http\Middleware\Api;

use App\Http\Responses\ApiResponse;
use Closure;

class CheckAppToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = "RkJBUfQZSCNwnfZlJub4";

        if (!empty($request->header('appToken')) && $request->header('appToken') === $token) {
            return $next($request);
        }

        return ApiResponse::error(['error_code' => 0], 400);
    }
}
