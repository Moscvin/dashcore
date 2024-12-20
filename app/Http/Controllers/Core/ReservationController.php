<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CoreReservationRequest;
use App\Models\Core\CoreUser;
use App\Models\Doctor;
use App\Repositories\Core\CoreReservationRepository;
use App\Models\Reservation;
use App\Models\ReservationSlot;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');
        return view('core.reservations.index');
    }

    public function ajax(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $dataTable = (new CoreReservationRepository(new Reservation()))->getDataTablesFiltered($request);
        $index = 0;
        $items = [];
        foreach ($dataTable->items as $item) {
            if ($item->core_user_id != Auth::id()) {
                continue;
            }

            $items[$index] = [
                'active' => $item->status,
                $item->coreUser->username ?? '',
                $item->doctor->name ?? '',
                $item->specialization->specialization_name ?? '',
            ];

            if (in_array("V", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_reservations/$item->id\" class=\"btn btn-xs btn-primary\" title=\"Vizualizează\">
                    <i class=\"fa fa-eye\"></i>
                </a>"
                );
            }
            if (in_array("E", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_reservations/$item->id/edit\" class=\"btn btn-xs btn-info\" title=\"Editează\">
                    <i class=\"fa fa-edit\"></i>
                </a>"
                );
            }
            if (in_array("L", $this->chars)) {
                $btnClass = $item->status == 1 ? 'warning' : 'primary';
                $icon = $item->status == 1 ? 'lock' : 'unlock';
                $title = $item->status == 1 ? 'Ascunde' : 'Afișează';
                array_push(
                    $items[$index],
                    "<button onclick='reservationLockItem(this)' title=\"$title\" data-id=\"$item->id\" data-current=\"$item->status\"
                    type=\"button\" class=\"action_block btn btn-xs btn-$btnClass\">
                    <i class=\"fa fa-$icon\"></i>
                </button>"
                );
            }

            if (in_array("D", $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='reservationDeleteItem(this)' data-id=\"$item->id\" type=\"button\"
                    class=\"action_del btn btn-xs btn-danger\" title=\"Șterge\">
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
        $doctors = Doctor::all();
        $specializations = Specialization::all();
        $reservationSlots = ReservationSlot::all();
        return view('core.reservations.create', compact('doctors', 'specializations', 'reservationSlots'));
    }

    public function store(CoreReservationRequest $request)
    {
        if (!in_array('A', $this->chars)) {
            return redirect('/no_permission');
        }

        try {
            $existingReservation = Reservation::where('core_user_id', Auth::id())
                ->where('specialization_id', $request->specialization_id)
                ->first();

            // if ($existingReservation) {
            //     return back()->withErrors(['error' => 'Existing this reservation'])->withInput();
            // }

            // // Verifică dacă toate sloturile de timp sunt în viitor
            // foreach ($request->slot_times as $slotTime) {
            //     if (Carbon::parse($slotTime)->isPast()) {
            //         return back()->withErrors(['error' => 'All slot times must be in the future'])->withInput();
            //     }
            // }

            $reservation = Reservation::create([
                'core_user_id' => Auth::id(),
                'specialization_id' => $request->specialization_id,
                'doctor_id' => null,
                'status' => '0',
            ]);

            foreach ($request->slot_times as $slotTime) {
                ReservationSlot::create([
                    'time' => $slotTime,
                    'reservation_id' => $reservation->id,
                ]);
            }

            return redirect()->route('core_reservations.index')->with('success', 'Reservation created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error to create'])->withInput();
        }
    }

    public function show(Reservation $coreReservation)
    {
        if (!in_array('V', $this->chars)) return redirect('/no_permission');

        if ($coreReservation->core_user_id != Auth::id()) {
            return redirect()->route('core_reservations.index')->with('error', 'You dont have permission to show this reservation');
        }
        return view('core.reservations.show', compact('coreReservation'));
    }

    public function edit(Reservation $coreReservation)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        if ($coreReservation->core_user_id != Auth::id()) {
            return redirect()->route('core_reservations.index')->with('error', 'You dont have permission to edit this reservation');
        }
        if ($coreReservation->status == 1) {
            Session::flash('error', 'Reservation is blocked!');
            return redirect()->route('core_reservations.index');
        }

        $clients = CoreUser::all();
        $doctors = Doctor::all();
        $specializations = Specialization::all();
        $reservationSlots = ReservationSlot::all();

        return view('core.reservations.edit', compact('coreReservation', 'clients', 'doctors', 'specializations', 'reservationSlots'));
    }

    public function update(CoreReservationRequest $request, Reservation $coreReservation)
    {
        if ($coreReservation->core_user_id != Auth::id()) {
            return redirect()->route('core_reservations.index')->with('error', 'You dont have permission to edit this reservation');
        }
        if ($coreReservation->status != 0) {
            return redirect()->route('core_reservations.index')->with('error', 'Reservation its block and dont change');
        }

        try {
            $existingReservation = Reservation::where('core_user_id', Auth::id())
                ->where('specialization_id', $request->specialization_id)
                ->where('id', '!=', $coreReservation->id)
                ->first();

            if ($existingReservation) {
                return back()->withErrors(['error' => 'You have this reservation'])->withInput();
            }

            $coreReservation->update([
                'specialization_id' => $request->specialization_id,
            ]);

            $coreReservation->reservationSlots()->delete();

            foreach ($request->slot_times as $slotTime) {
                $coreReservation->reservationSlots()->create([
                    'time' => $slotTime,
                ]);
            }

            return redirect()->route('core_reservations.index')->with('success', 'Reservation updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error'])->withInput();
        }
    }

    public function lock(Request $request, Reservation $coreReservation)
    {
        if (!in_array('L', $this->chars)) return redirect('/no_permission');

        $coreReservation->update(['status' => $request->lock ? Reservation::STATUS_UNLOCKED : Reservation::STATUS_LOCKED]);

        return response()->json(['status' => 'Success'], 200);
    }

    public function destroy(Reservation $coreReservation)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreReservation->delete();

        return response()->json(['status' => 'Success'], 204);
    }

    public function getDoctorsBySpecialization(Request $request)
    {
        $specializationId = $request->input('specialization_id');

        if (!$specializationId) {
            return response()->json(['error' => 'Specialization ID is required'], 400);
        }

        $doctors = Doctor::where('specialization_id', $specializationId)->get();

        return response()->json($doctors);
    }
}
