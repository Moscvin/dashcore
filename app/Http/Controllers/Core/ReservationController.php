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
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use Illuminate\Support\Facades\Auth;


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
            $items[$index] = [
                $item->coreUser->username ?? '',
                $item->doctor->name ?? '',
                $item->specialization->specialization_name ?? '',
                $item->reservationSlot->time ?? '',
                // $item->status ?? '',
            ];



            if (in_array("V", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_reservations/$item->id\" class=\"btn btn-xs btn-primary\" title=\"Visualizza\">
                        <i class=\"fa fa-eye\"></i>
                    </a>"
                );
            }
            if (in_array("E", $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"/core_reservations/$item->id/edit\" class=\"btn btn-xs btn-info\" title=\"Modifica\">
                        <i class=\"fa fa-edit\"></i>
                    </a>"
                );
            }
            if (in_array("L", $this->chars)) {
                $btnClass = $item->status == 1 ? 'warning' : 'primary';
                $icon = $item->status == 1 ? 'lock' : 'unlock';
                $title = $item->status == 1 ? 'Nascondi' : 'Mostra';
                array_push(
                    $items[$index],
                    "<button onclick='reservationLockItem(this)' title=\"$title\"  data-id=\"$item->id\" data-current=\"$item->status\"
                            type=\"button\" class=\"action_block btn btn-xs btn-$btnClass\">
                        <i class=\"fa fa-$icon\"></i>
                    </button>"
                );
            }

            if (in_array("D", $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='reservationDeleteItem(this)' data-id=\"$item->id\" type=\"button\"
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
        $doctors = Doctor::all();
        $specializations = Specialization::all();
        $reservationSlots = ReservationSlot::all();
        return view('core.reservations.create', compact('doctors', 'specializations', 'reservationSlots'));
    }

    public function store(CoreReservationRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        $reservationData = $this->fillCoreReservation($request);
        $reservationData['core_user_id'] = Auth::id();

        $reservation = Reservation::create($reservationData);

        $reservation->load(['coreUser', 'doctor', 'specialization', 'reservationSlot']);

        // Mail::to($reservation->coreUser->email)->send(new ReservationMail($reservation));

        Session::flash('success', 'Reservation is adding!');
        return redirect('/core_reservations');
    }

    public function show(Reservation $coreReservation)
    {
        if (!in_array('V', $this->chars)) return redirect('/no_permission');

        return view('core.reservations.show', compact('coreReservation'));
    }

    public function edit(Reservation $coreReservation)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');


        $clients = CoreUser::all();
        $doctors = Doctor::all();
        $specializations = Specialization::all();
        $reservationSlots = ReservationSlot::all();


        return view('core.reservations.edit', compact('coreReservation', 'clients', 'doctors', 'specializations', 'reservationSlots'));
    }

    public function update(CoreReservationRequest $request, Reservation $coreReservation)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreReservation->update($request->validated());

        Session::flash('success', 'Le modifiche son salavate!');
        return redirect('/core_reservations');
    }

    public function lock(Request $request, Reservation $coreReservation)
    {
        if (!in_array('L', $this->chars)) return redirect('/no_permission');

        $coreReservation->update([
            'status' => $request->lock ? '0' : '1',

        ]);

        return response()->json(['status' => 'Success'], 200);
    }

    public function destroy(Reservation $coreReservation)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreReservation->delete();

        return response()->json(['status' => 'Success'], 204);
    }
    private function fillCoreReservation($request)
    {
        return [
            'core_user_id' => $request->core_user_id,
            'doctor_id' => $request->doctor_id,
            'specialization_id' => $request->specialization_id,
            'reservation_slot_id' => $request->reservation_slot_id,
        ];
    }
    public function getDoctorsBySpecialization(Request $request)
    {
        $specializationId = $request->input('specialization_id');

        if (!$specializationId) {
            return response()->json(['error' => 'Specialization ID is required'], 400);
        }

        $doctors = Doctor::whereHas('specializations', function ($query) use ($specializationId) {
            $query->where('specialization_id', $specializationId);
        })->get();

        return response()->json($doctors);
    }
    // public function getDoctorByReservationSlot(Request $request)
    // {
    //     $reservationSlotId = $request->input('reservation_slot_id');

    //     if (!$reservationSlotId) {
    //         return response()->json(['error' => 'Reservation Slot ID is required'], 400);
    //     }

    //     $doctor = Doctor::whereHas('reservationSlots', function ($query) use ($reservationSlotId) {
    //         $query->where('id', $reservationSlotId);
    //     })->get();

    //     return response()->json($doctor);
    // }
    public function getAvailableSlots(Request $request)
    {
        $doctorId = $request->input('doctor_id');

        if (!$doctorId) {
            return response()->json(['error' => 'Doctor ID is required'], 400);
        }

        $slots = ReservationSlot::where('doctor_id', $doctorId)
            ->where('is_booked', false)
            ->get();

        return response()->json($slots);
    }
}
