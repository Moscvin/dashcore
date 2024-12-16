<?php

namespace App\Repositories\Core\Addresses;

use App\Repositories\BaseRepository;

class CoreCountryRepository extends BaseRepository
{
    public function getDataTablesFiltered($fields)
    {
        $query = clone $this->query;
        $recordsTotalCount = (clone $query)->count();
        if (!empty($fields->search['value'])) {
            $query->where('name', 'like', '%' . $fields->search['value'] . '%')
                ->orWhere('short_name', 'like', '%' . $fields->search['value'] . '%');
        }

        foreach ($fields->order as $condition) {
            switch ($condition['column']) {
                case 0:
                    $query = $query->orderBy('name', $condition['dir']);
                    break;
                case 1:
                    $query = $query->orderBy('short_name', $condition['dir']);
                    break;
            }
        }

        $recordsFilteredCount = (clone $query)->count();

        $itemsIds = (clone $query)->when(($fields['length'] ?? 0) > 0, function ($q) use ($fields) {
            $q->skip($fields['start'])->take($fields['length']);
        })->get(['core_countries.id'])->pluck(['id']);

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
