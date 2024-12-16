<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Core\CoreCustomerRequest;
use App\Repositories\Core\CoreCustomerRepository;
use App\Models\Core\Addresses\CoreCountry;
use App\Models\Core\CoreCustomer;
use App\Services\Core\Customers\CustomerVCardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoreCustomerController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        return view('core.customers.index');
    }

    public function ajax(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $dataTable = (new CoreCustomerRepository(new CoreCustomer))->getDataTablesFiltered($request);

        $index = 0;
        $items = [];

        foreach ($dataTable->items as $item) {
            $items[$index] = [
                $item->customerName,
                $item->vat,
                $item->code_fiscal,
                $item->headquarterCity,
                $item->customerPhones,
            ];
            
            if (in_array("V", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_customers/$item->id/vcard\" class=\"btn btn-xs btn-primary\" title=\"VCard\">
                        <i class=\"fa fa-address-card\"></i>
                    </a>"
                );
            }
            if (in_array("V", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_customers/$item->id\" class=\"btn btn-xs btn-primary\" title=\"Visualizza\">
                        <i class=\"fa fa-eye\"></i>
                    </a>"
                );
            }
            if (in_array("E", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_customers/$item->id/edit\" class=\"btn btn-xs btn-info\" title=\"Modifica\">
                        <i class=\"fa fa-edit\"></i>
                    </a>"
                );
            }
            if (in_array("L", $this->chars)) {
                $btnClass = $item->active == 1 ? 'warning' : 'primary';
                $icon = $item->active == 1 ? 'lock' : 'unlock';
                $title = $item->active == 1 ? 'Nascondi' : 'Mostra';
                array_push(
                    $items[$index],
                    "<button onclick='coreCustomerLockItem(this)' title=\"$title\"  data-id=\"$item->id\" data-current=\"$item->active\"
                            type=\"button\" class=\"action_block btn btn-xs btn-$btnClass\">
                        <i class=\"fa fa-$icon\"></i>
                    </button>"
                );
            }

            if (in_array("D", $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='coreCustomerDeleteItem(this)' data-id=\"$item->id\" type=\"button\"
                            class=\"action_del btn btn-xs btn-danger\" title=\"Elimina\">
                        <i class=\"fa fa-trash\"></i>
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

        $coreCountries = CoreCountry::orderBy('name', 'asc')->get();
        return view('core.customers.create', compact('coreCountries'));
    }

    public function store(CoreCustomerRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        CoreCustomer::create($this->fillCoreCustomerCustomer($request));

        Session::flash('success', 'Il cliente è aggiunto!');
        return redirect('/core_customers');
    }

    public function show(CoreCustomer $coreCustomer)
    {
        if (!in_array('V', $this->chars)) return redirect('/no_permission');

        return view('core.customers.show', compact('coreCustomer'));
    }

    public function edit(CoreCustomer $coreCustomer)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreCountries = CoreCountry::orderBy('name', 'asc')->get();
        return view('core.customers.edit', compact('coreCustomer', 'coreCountries'));
    }

    public function update(CoreCustomerRequest $request, CoreCustomer $coreCustomer)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreCustomer->update($this->fillCoreCustomerCustomer($request));

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect('/core_customers');
    }

    public function lock(Request $request, CoreCustomer $coreCustomer)
    {
        if (!in_array('L', $this->chars)) return redirect('/no_permission');

        $coreCustomer->update([
            'active' => !$request->lock,
        ]);

        return response()->json(['status' => 'Success'], 200);
    }

    public function destroy(CoreCustomer $coreCustomer)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreCustomer->delete();

        return response()->json(['status' => 'Success'], 204);
    }

    public function getVCard(CoreCustomer $coreCustomer)
    {
        return (new CustomerVCardService($coreCustomer))->download();
    }

    private function fillCoreCustomerCustomer($request)
    {
        if ($request->is_company == 1) {
            $data = [
                'is_company' => 1,
                'company_name' => $request->company_name,
                'country_fiscal' => $request->country_fiscal,
                'vat' => $request->vat,
                'code_fiscal' => $request->code_fiscal,
            ];
        } else {
            $data = [
                'is_company' => 0,
                'surname' => $request->surname,
                'name' => $request->name,
                'country_birth' => $request->country_birth,
                'date_birth' => Carbon::createFromFormat('d/m/Y', $request->date_birth)->format('Y-m-d'),
                'city_birth' => $request->city_birth,
                'province_birth' => $request->province_birth,
                'country_fiscal' => $request->country_fiscal,
                'code_fiscal' => $request->code_fiscal_individual,
            ];
        }

        $data = array_merge($data, [
            'prefix_1' => $request->prefix_1,
            'phone_1' => $request->phone_1,
            'prefix_2' => $request->prefix_2,
            'phone_2' => $request->phone_2,
            'prefix_fax' => $request->prefix_fax,
            'fax' => $request->fax,
            'email' => $request->email,
            'pec' => $request->pec,

            'country_sl' => $request->country_sl,
            'province_sl' => $request->province_sl,
            'city_sl' => $request->city_sl,
            'location_sl' => $request->location_sl,
            'zip_sl' => $request->zip_sl,
            'street_address_sl' => $request->street_address_sl,
            'house_number_sl' => $request->house_number_sl,

            'country_so' => $request->country_so,
            'province_so' => $request->province_so,
            'city_so' => $request->city_so,
            'location_so' => $request->location_so,
            'zip_so' => $request->zip_so,
            'street_address_so' => $request->street_address_so,
            'house_number_so' => $request->house_number_so,

            'rl_surname' => $request->rl_surname,
            'rl_name' => $request->rl_name,
            'rl_email' => $request->rl_email,
            'rl_prefix_1' => $request->rl_prefix_1,
            'rl_prefix_2' => $request->rl_prefix_2,
            'rl_phone_1' => $request->rl_phone_1,
            'rl_phone_2' => $request->rl_phone_2,

            'referent_description' => $request->rl_phone_2,
            'referent_name' => $request->referent_name,
            'referent_surname' => $request->referent_surname,
            'referent_prefix_1' => $request->referent_prefix_1,
            'referent_prefix_2' => $request->referent_prefix_2,
            'referent_phone_1' => $request->referent_phone_1,
            'referent_phone_2' => $request->referent_phone_2,
            'referent_email' => $request->referent_email,
        ]);
        return $data;
    }
}
