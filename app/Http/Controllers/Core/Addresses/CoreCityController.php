<?php

namespace App\Http\Controllers\Core\Addresses;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Core\Addresses\CoreCityRequest;
use App\Repositories\Core\Addresses\CoreCityRepository;
use App\Models\Core\Addresses\CoreCity;
use App\Models\Core\Addresses\CoreProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoreCityController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        return view('core.addresses.cities.index');
    }

    public function ajax(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $dataTable = (new CoreCityRepository(new CoreCity))->getDataTablesFiltered($request);

        $index = 0;
        $items = [];
        foreach ($dataTable->items as $item) {

            $items[$index] = [
                $item->name,
                $item->zip,
                $item->coreProvince->name,
            ];
            if (in_array('E', $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"" . route('core_cities.edit', $item->id) . "\" class='btn btn-xs btn-info'
                            title='Modifica'>
                        <i class='fas fa-edit'></i>
                    </a>"
                );
            }
            if (in_array('D', $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='coreCityDeleteItem(this)' data-id=\"$item->id\" type='button'
                            class='action_del btn btn-xs btn-danger' title='Elimina'>
                        <i class='fa fa-trash'></i>
                    </button>"
                );
            }

            $index++;
        }

        return response()->json([
            'start' => $request->start,
            'length' => $request->length,
            'draw' => $request->draw,
            'recordsTotal' => $dataTable->recordsTotal,
            'recordsFiltered' => $dataTable->recordsFiltered,
            "data" => $items,
        ]);
    }

    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        $coreProvinces = CoreProvince::orderBy('name', 'asc')->get();
        return view('core.addresses.cities.create', compact('coreProvinces'));
    }

    public function store(CoreCityRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        CoreCity::create([
            'core_province_id' => $request->core_province_id,
            'name' => $request->name,
            'zip' => $request->zip,
        ]);

        Session::flash('success', 'Comune aggiunta correttamente!');
        return redirect()->route('core_cities.index');
    }

    public function edit(Request $request, CoreCity $coreCity)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreProvinces = CoreProvince::orderBy('name', 'asc')->get();
        return view('core.addresses.cities.edit', compact('coreProvinces', 'coreCity'));
    }

    public function update(CoreCityRequest $request, CoreCity $coreCity)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreCity->update([
            'core_province_id' => $request->core_province_id,
            'name' => $request->name,
            'zip' => $request->zip,
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_cities.index');
    }

    public function destroy(CoreCity $coreCity)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreCity->delete();

        return response()->json([], 204);
    }
}
