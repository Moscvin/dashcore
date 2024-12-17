<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\DoctorSpecialization;
use App\Http\Requests\CoreSpecializationDoctorRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Doctor;
use App\Models\Specialization;

class DoctorSpecializationController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $doctorSpecializations = DoctorSpecialization::with('doctor', 'specialization')->get();
        return view('core.doctor_specializations.index', compact('doctorSpecializations'));
    }

    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        $doctors = Doctor::all();
        $specializations = Specialization::all();

        return view('core.doctor_specializations.create', compact('doctors', 'specializations'));
    }

    public function store(CoreSpecializationDoctorRequest $request)
    {
        if (!in_array('A', $this->chars)) {
            return redirect('/no_permission');
        }

        DoctorSpecialization::create([
            'doctor_id' => $request->doctor_id,
            'specialization_id' => $request->specialization_id,
        ]);


        Session::flash('success', 'Il dottore è stato aggiunto!');
        return redirect()->route('doctor_specialization.index');
    }

    public function edit(DoctorSpecialization $doctorSpecialization)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $doctors = Doctor::all();
        $specializations = Specialization::all();

        return view('core.doctor_specializations.edit', compact('doctorSpecialization', 'doctors', 'specializations'));
    }

    public function update(CoreSpecializationDoctorRequest $request, DoctorSpecialization $doctorSpecialization)
    {
        if (!in_array('E', $this->chars)) {
            return redirect('/no_permission');
        }

        $doctorSpecialization->update([
            'doctor_id' => $request->doctor_id,
            'specialization_id' => $request->specialization_id,
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('doctor_specialization.index');
    }

    public function destroy(DoctorSpecialization $doctorSpecialization)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $doctorSpecialization->delete();


        return response()->json([], 204);
    }
}
