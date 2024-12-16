<?php

namespace App\Http\Controllers\Core;

class RouteErrorController
{
    public function fallback()
    {
        return view('errors.404');
    }

    public function noPermission()
    {
        return view('errors.no_permission');
    }
}
