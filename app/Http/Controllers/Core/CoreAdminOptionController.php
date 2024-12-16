<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Core\CoreAdminOptionRequest;
use App\Models\Core\CoreAdminOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoreAdminOptionController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreAdminOptions = CoreAdminOption::get();
        return view('core.admin_options.index', compact('coreAdminOptions'));
    }

    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        return view('core.admin_options.create');
    }

    public function store(CoreAdminOptionRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        CoreAdminOption::create([
            'description' => $request->description,
            'value' => $request->value,
        ]);

        Session::flash('success', 'L\'opzioni è stato aggiunto!');
        return redirect()->route('core_admin_options.index');
    }

    public function edit(Request $request, CoreAdminOption $coreAdminOption)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        return view('core.admin_options.edit', compact('coreAdminOption'));
    }

    public function update(CoreAdminOptionRequest $request, CoreAdminOption $coreAdminOption)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreAdminOption->update([
            'description' => $request->description,
            'value' => $request->value,
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_admin_options.index');
    }

    public function destroy(Request $request, CoreAdminOption $coreAdminOption)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreAdminOption->delete();

        return response()->json([], 204);
    }
}
