<?php

namespace App\Http\Middleware\Api;

use App\Http\Responses\ApiResponse;
use App\Models\Core\CoreUser;
use Closure;

class CheckUserToken
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
        if (!empty($request->header('userToken'))) {
            $user = CoreUser::where('app_token', $request->header('userToken'))->first();
            if ($user) {
                return $next($request);
            }
        }

        return ApiResponse::error(['error_code' => 1], 400);
    }
}
