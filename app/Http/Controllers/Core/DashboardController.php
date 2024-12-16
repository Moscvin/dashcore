<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return redirect()->route('home');
    }

    public function home()
    {
        return view('core.home.index');
    }
}
