<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CoreSlotRequest;
use Illuminate\Support\Facades\Session;
use App\Models\ReservationSlot;
use App\Models\Doctor;
use Illuminate\Support\Carbon;

class ReservationSlotController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $reservationSlots = ReservationSlot::with('doctor')->get();
        return view('core.reservations_slots.index', compact('reservationSlots'));
    }
    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');
        $doctors = Doctor::all();
        return view('core.reservations_slots.create', compact('doctors'));
    }
    public function store(CoreSlotRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        ReservationSlot::create([
            'time' => \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $request->time)->toDateTimeString(),
            'doctor_id' => $request->doctor_id,
        ]);

        Session::flash('success', 'Il specialization_name è stato aggiunto!');

        return redirect()->route('core_reservation_slots.index');
    }

    public function edit(ReservationSlot $reservationSlot)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $reservationSlot->time = Carbon::parse($reservationSlot->time)->format('d-m-Y H:i');
        $doctors = Doctor::all();
        return view('core.reservations_slots.edit', compact('reservationSlot', 'doctors'));
    }

    public function update(CoreSlotRequest $request, ReservationSlot $reservationSlot)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');
        $reservationSlot->update([
            'time' => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->time)->toDateTimeString(),
            'doctor_id' => $request->doctor_id,
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_reservation_slots.index');
    }

    public function destroy(ReservationSlot $reservationSlot)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $reservationSlot->delete();

        return response()->json([], 204);
    }
}
