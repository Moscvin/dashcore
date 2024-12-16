<?php

namespace App\Http\Controllers\Core\Addresses;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Core\Addresses\CoreCountryRequest;
use App\Repositories\Core\Addresses\CoreCountryRepository;
use App\Models\Core\Addresses\CoreCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoreCountryController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreCountries = CoreCountry::get();
        return view('core.addresses.countries.index', compact('coreCountries'));
    }

    public function ajax(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $dataTable = (new CoreCountryRepository(new CoreCountry))->getDataTablesFiltered($request);

        $index = 0;
        $items = [];
        foreach ($dataTable->items as $item) {

            $items[$index] = [
                $item->name,
                $item->short_name,
            ];

            if (in_array('E', $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"" . route('core_countries.edit', $item->id) . "\" class='btn btn-xs btn-info' title='Modifica'>
                        <i class='fas fa-edit'></i>
                    </a>"
                );
            }
            if (in_array('D', $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='coreCountryDeleteItem(this)' data-id=\"" . $item->id . "\" type='button'
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

        return view('core.addresses.countries.create');
    }

    public function store(CoreCountryRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        $coreCountry = CoreCountry::create([
            'name' => $request->name,
            'short_name' => strtoupper($request->short_name),
        ]);

        Session::flash('success', 'Nazioni aggiunta correttamente!');
        return redirect()->route('core_countries.index');
    }

    public function edit(CoreCountry $coreCountry)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        return view('core.addresses.countries.edit', compact('coreCountry'));
    }

    public function update(CoreCountryRequest $request, CoreCountry $coreCountry)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreCountry->update([
            'name' => $request->name,
            'short_name' => strtoupper($request->short_name),
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_countries.index');
    }

    public function destroy(CoreCountry $coreCountry)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreCountry->delete();

        return response()->json([], 204);
    }
}
