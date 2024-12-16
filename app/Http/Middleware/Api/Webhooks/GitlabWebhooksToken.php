<?php

namespace App\Http\Middleware\Api\Webhooks;

use Closure;
use Illuminate\Support\Facades\Storage;

class GitlabWebhooksToken
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
        if($request->header('X-Gitlab-Token') == config('gitconfig.webhooksToken.gitlab')) {
            return $next($request);
        }
        
        return response()->json([
            'error' => [
                'message' => 'Wrong X-Gitlab-Token',
            ]
        ], 500);
    }
}
