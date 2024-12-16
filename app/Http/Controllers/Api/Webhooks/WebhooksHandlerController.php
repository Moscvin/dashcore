<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class WebhooksHandlerController extends Controller
{
    public function main(Request $request)
    {
        if (method_exists($this, $request->event_name)) {
            $this->{$request->event_name}($request->all());
            return response()->json([
                'success' => [
                    'message' => 'Success',
                ],
            ], 200);
        } else {
            // log exception
            return response()->json([
                'success' => [
                    'error' => 'Event doesnt exist',
                ],
            ], 500);
        }
    }

    private function push($params)
    {
        Artisan::call('git:onpush');
        Artisan::call('optimize:clear');
    }
}
