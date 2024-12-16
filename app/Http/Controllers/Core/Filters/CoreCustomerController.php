<?php

namespace App\Http\Controllers\Core\Filters;

use App\Http\Controllers\Controller;
use App\Models\Core\CoreCustomer;
use Illuminate\Http\Request;

class CoreCustomerController extends Controller
{
    public function fieldFilter(Request $request)
    {
        $coreCustomers = CoreCustomer::where($request->field, 'like', '%' . $request->value . '%')->orderBy($request->field, 'asc')->limit(20)->get();

        return response()->json([
            'results' => $coreCustomers->map(function ($coreCustomer) use ($request) {
                return [
                    'id' => $coreCustomer->{$request->field},
                    'text' => $coreCustomer->{$request->field}
                ];
            }),
            'query' => $request->q,
        ], 200);
    }
}
