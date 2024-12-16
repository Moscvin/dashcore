<?php

namespace App\Http\Controllers\Core\Filters;

use App\Http\Controllers\Controller;
use App\Models\Core\Addresses\CoreCity;
use Illuminate\Http\Request;

class CoreCityServiceController extends Controller
{
    public function ajaxFilter(Request $request)
    {
        $coreCities = CoreCity::where('name', 'like', '%' . $request->name . '%')->when($request->zip, function ($q) use ($request) {
            $q->where('zip', $request->zip);
        })->limit(10)->get();

        return response()->json([
            'results' => $coreCities->map(function ($coreCity) {
                return [
                    'id' => $coreCity->name,
                    'text' => $coreCity->name,
                    'province' => $coreCity->coreProvince->short_name,
                ];
            }),
            'query' => $request->q,
        ], 200);
    }
}
