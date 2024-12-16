<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CoreReservationRepository extends BaseRepository
{

    public function getDataTablesFiltered($fields)
    {
        $query = clone $this->query;
        $query = $query
            ->join('core_users', 'reservations.core_user_id', '=', 'core_users.id')
            ->join('doctors', 'reservations.doctor_id', '=', 'doctors.id')
            ->join('doctor_specialization', 'doctors.id', '=', 'doctor_specialization.doctor_id')
            ->join('specializations', 'doctor_specialization.specialization_id', '=', 'specializations.id')
            ->join('reservation_slots', 'reservations.reservation_slot_id', '=', 'reservation_slots.id');

        $recordsTotalCount = (clone $query)->count();

        $query->when($fields['fieldFilter'] && $fields['valueFilter'], function ($q) use ($fields) {
            switch ($fields['fieldFilter']) {
                case 'core_user_id':
                    $q->where('reservations.core_user_id', 'like', '%' . $fields['valueFilter'] . '%')
                        ->orWhere('core_users.username', 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                case 'doctor_id':
                    $q->where('reservations.doctor_id', 'like', '%' . $fields['valueFilter'] . '%')
                        ->orWhere('doctors.name', 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                case 'specialization_id':
                    $q->where('specializations.specialization_name', 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                case 'reservation_slot_id':
                    $q->where('reservation_slots.time', 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                case 'status':
                    $q->where('reservations.status', 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                default:
                    $q->where($fields['fieldFilter'], 'like', '%' . $fields['valueFilter'] . '%');
                    break;
            }
        });

        foreach ($fields->order as $condition) {
            switch ($condition['column']) {
                case 0:
                    $query = $query->orderBy(DB::raw("CONCAT(core_users.name, ' ', core_users.surname)"), $condition['dir']);
                    break;
                case 1:
                    $query = $query->orderBy('doctors.name', $condition['dir']);
                    break;
                case 2:
                    $query = $query->orderBy('specializations.specialization_name', $condition['dir']);
                    break;
                case 3:
                    $query = $query->orderBy('reservation_slots.time', $condition['dir']);
                    break;
                case 4:
                    $query = $query->orderBy('reservations.status', $condition['dir']);
                    break;
                default:
                    $query = $query->orderBy($fields->columns[$condition['column']]['data'], $condition['dir']);
                    break;
            }
        }

        $recordsFilteredCount = (clone $query)->count();

        $itemsIds = (clone $query)->when(($fields['length'] ?? 0) > 0, function ($q) use ($fields) {
            $q->skip($fields['start'])->take($fields['length']);
        })->get(['reservations.id'])->pluck(['id']);

        $items = (clone $this->query)->whereIn('id', $itemsIds)->get()->sortBy(function ($item) use ($itemsIds) {
            return array_search($item->getKey(), $itemsIds->toArray());
        })->values();

        return (object) [
            'items' => $items,
            'recordsTotal' => $recordsTotalCount,
            'recordsFiltered' => $recordsFilteredCount,
        ];
    }
}
