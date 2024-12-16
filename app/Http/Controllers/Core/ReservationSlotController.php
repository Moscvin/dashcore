<?php

namespace App\Http\Controllers\Core;

use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CoreSlotRequest;
use Illuminate\Support\Facades\Session;
USE App\Models\ReservationSlot;

class ReservationSlotController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreSlots = ReservationSlot::get();
        return view('core.reservations_slots.index', compact('coreSlots'));
    }
    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        return view('core.reservations_slots.create');
    }
    public function store(CoreSlotRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        ReservationSlot::create(['time' => $request->time]);

        Session::flash('success', 'Il specialization_name è stato aggiunto!');
        
        return redirect()->route('core_reservations_slots.index');
    }

    public function edit(ReservationSlot $coreSlots)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');
        return view('core.reservations_slots.edit', compact('coreSlots'));
    }

    public function update(CoreSlotRequest $request, ReservationSlot $coreSlots)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreSlots->update(['time' => $request->time]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_reservations_slots.index');
    }

    public function destroy(ReservationSlot $coreSlots)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreSlots->delete();

        return response()->json([], 204);
    }
}
