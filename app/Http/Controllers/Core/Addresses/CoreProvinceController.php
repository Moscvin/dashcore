<?php

namespace App\Http\Controllers\Core\Addresses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Models\Core\Addresses\CoreProvince;
use App\Http\Requests\Core\Addresses\CoreProvinceRequest;
use App\Repositories\Core\Addresses\CoreProvinceRepository;

class CoreProvinceController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreProvinces = CoreProvince::get();
        return view('core.addresses.provinces.index', compact('coreProvinces'));
    }

    public function ajax(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $dataTable = (new CoreProvinceRepository(new CoreProvince))->getDataTablesFiltered($request);
        $index = 0;
        $items = [];
        foreach ($dataTable->items as $item) {

            $items[$index] = [
                $item->name,
                $item->short_name,
                $item->core_cities_count,
            ];

            if (in_array('E', $this->chars)) {
                array_push($items[$index],
                    "<a href=\"" . route('core_provinces.edit', $item->id) . "\" class='btn btn-xs btn-info' title='Modifica'>
                        <i class='fas fa-edit'></i>
                    </a>"
                );
            }
            if (in_array('D', $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='coreProvinceDeleteItem(this)' data-id=\"" . $item->id . "\" type='button'
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

        return view('core.addresses.provinces.create');
    }

    public function store(CoreProvinceRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');
        $coreProvince = CoreProvince::create([
            'name' => $request->name,
            'short_name' => strtoupper($request->short_name)
        ]);

        Session::flash('success', 'Province aggiunta correttamente!');
        return redirect()->route('core_provinces.index');
    }

    public function edit(CoreProvince $coreProvince)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');
        return view('core.addresses.provinces.edit', compact('coreProvince'));
    }

    public function update(CoreProvinceRequest $request, CoreProvince $coreProvince)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreProvince->update([
            'name' => $request->name,
            'short_name' => strtoupper($request->short_name),
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_provinces.index');
    }

    public function destroy(CoreProvince $coreProvince)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreProvince->delete();

        return response()->json([], 204);
    }
}
