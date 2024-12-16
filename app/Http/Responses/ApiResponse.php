<?php
namespace App\Http\Responses;


class ApiResponse
{
    public static function success($data, $code = 200)
    {
        return response()->json([
            'data' => $data
        ], $code);
    }

    public static function error($error, $code = 500)
    {
        return response()->json([
            'error' => $error
        ], $code);
    }

    public static function download($path)
    {
        return response()->download($path);
    }
}
