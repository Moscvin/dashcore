<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CoreDoctorRequest;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Support\Facades\Session;



class CoreDoctorController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreDoctors = Doctor::get();
        return view('core.doctors.index', compact('coreDoctors'));
    }

    public function store(CoreDoctorRequest $request)
    {
        if (!in_array('A', $this->chars)) {
            return redirect('/no_permission');
        }

        Doctor::create([
            'name' => $request->name,
        ]);


        Session::flash('success', 'Il dottore è stato aggiunto!');
        return redirect()->route('core_doctors.index');
    }

    public function edit(Doctor $coreDoctor)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        return view('core.doctors.edit', compact('coreDoctor'));
    }

    public function create()
    {

        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        return view('core.doctors.create');
    }

    public function update(CoreDoctorRequest $request, Doctor $coreDoctor)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreDoctor->update(['name' => $request->name]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_doctors.index');
    }

    public function destroy(Doctor $coreDoctor)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreDoctor->delete();

        return response()->json([], 204);
    }
}
