<?php

namespace App\Repositories\Core\Addresses;

use App\Repositories\BaseRepository;

class CoreCityRepository extends BaseRepository
{

    public function getDataTablesFiltered($fields)
    {
        $query = clone $this->query;
        $recordsTotalCount = (clone $query)->count();
        if (!empty($fields->search['value'])) {
            $query->where('core_cities.name', 'like', '%' . $fields->search['value'] . '%')
                ->orWhere('core_cities.zip', 'like', '%' . $fields->search['value'] . '%')
                ->orWhereHas('coreProvince', function ($q) use ($fields) {
                    $q->where('core_provinces.name', 'like', '%' . $fields->search['value'] . '%');
                });
        }

        foreach ($fields->order as $condition) {
            switch ($condition['column']) {
                case 0:
                    $query = $query->orderBy('core_cities.name', $condition['dir']);
                    break;
                case 1:
                    $query = $query->orderBy('core_cities.zip', $condition['dir']);
                    break;
                case 2:
                    $query->join('core_provinces', 'core_provinces.id', '=', 'core_cities.core_province_id')
                        ->orderBy('core_provinces.name', $condition['dir']);
                    break;
            }
        }

        $recordsFilteredCount = (clone $query)->count();

        $itemsIds = (clone $query)->when(($fields['length'] ?? 0) > 0, function ($q) use ($fields) {
            $q->skip($fields['start'])->take($fields['length']);
        })->get(['core_cities.id'])->pluck(['id']);

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
