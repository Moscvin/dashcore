<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CoreDoctorRepository extends BaseRepository
{
    public function getDataTablesFiltered($fields)
    {
        $query = clone $this->query;
        $recordsTotalCount = (clone $query)->count();

        $query->when($fields['fieldFilter'] && $fields['valueFilter'], function ($q) use ($fields) {
            switch ($fields['fieldFilter']) {
                case 'name':
                    $q->where('name', 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                case 'specialization':
                    $q->where('specialization', 'like', '%' . $fields['valueFilter'] . '%');
                default:
                    $q->where($fields['fieldFilter'], 'like', '%' . $fields['valueFilter'] . '%');
                    break;
            }
        });

        foreach ($fields->order as $condition) {
            switch ($condition['column']) {
                case 0:
                    $query = $query->orderBy('name', $condition['dir']);
                    break;
                case 1:
                    $query = $query->orderBy('specialization', $condition['dir']);
                    break;
                case 2:
                    $query = $query->orderBy('created_at', $condition['dir']);
                    break;
            }
        }


        $recordsFilteredCount = (clone $query)->count();

        $itemsIds = (clone $query)->when(($fields['length'] ?? 0) > 0, function ($q) use ($fields) {
            $q->skip($fields['start'])->take($fields['length']);
        })->get(['id'])->pluck('id');

        $items = (clone $this->query)->whereIn('id', $itemsIds)->get()->sortBy(function ($item) use ($itemsIds) {
            return array_search($item->getKey(), $itemsIds->toArray());
        })->values();

        return [
            'recordsTotal' => $recordsTotalCount,
            'recordsFiltered' => $recordsFilteredCount,
            'data' => $items
        ];
    }
}
