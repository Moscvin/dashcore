<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Core\CoreGroupRequest;
use App\Models\Core\CoreGroup;
use Illuminate\Support\Facades\Session;

class CoreGroupController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreGroups = CoreGroup::get();
        return view('core.groups.index', compact('coreGroups'));
    }

    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        return view('core.groups.create');
    }

    public function store(CoreGroupRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        CoreGroup::create(['name' => $request->name]);

        Session::flash('success', 'Il gruppo è stato aggiunto!');
        return redirect()->route('core_groups.index');
    }

    public function edit(CoreGroup $coreGroup)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        return view('core.groups.edit', compact('coreGroup'));
    }

    public function update(CoreGroupRequest $request, CoreGroup $coreGroup)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreGroup->update(['name' => $request->name]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_groups.index');
    }

    public function destroy(CoreGroup $coreGroup)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreGroup->delete();

        return response()->json([], 204);
    }
}
