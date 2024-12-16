<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CoreSpecializationRequest;

class SpecializationController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreSpecializations = Specialization::get();
        return view('core.specialization.index', compact('coreSpecializations'));
    }
    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        return view('core.specialization.create');
    }
    public function store(CoreSpecializationRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        Specialization::create(['specialization_name' => $request->specialization_name]);

        Session::flash('success', 'Il specialization_name è stato aggiunto!');
        
        return redirect()->route('core_specialization.index');
    }

    public function edit(Specialization $coreSpecializations)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');
        return view('core.specialization.edit', compact('coreSpecializations'));
    }

    public function update(CoreSpecializationRequest $request, Specialization $coreSpecializations)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreSpecializations->update(['specialization_name' => $request->specialization_name]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_specialization.index');
    }

    public function destroy(Specialization $coreSpecializations)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreSpecializations->delete();

        return response()->json([], 204);
    }
}
