<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;

class CoreUserRepository extends BaseRepository
{
    public function getDataTablesFiltered($fields)
    {
        $query = clone $this->query;
        $recordsTotalCount = (clone $query)->count();
        if (!empty($fields->search['value'])) {
            $query->where('username', 'like', '%' . $fields->search['value'] . '%')
                ->orWhere('surname', 'like', '%' . $fields->search['value'] . '%')
                ->orWhere('name', 'like', '%' . $fields->search['value'] . '%')
                ->orWhere('email', 'like', '%' . $fields->search['value'] . '%')
                ->orWhereHas('coreGroup', function ($q) use ($fields) {
                    $q->where('core_groups.name', 'like', '%' . $fields->search['value'] . '%');
                });
        }

        foreach ($fields->order as $condition) {
            switch ($condition['column']) {
                case 0:
                    $query = $query->orderBy('username', $condition['dir']);
                    break;
                case 1:
                    $query = $query->orderBy('surname', $condition['dir']);
                    break;
                case 2:
                    $query = $query->orderBy('name', $condition['dir']);
                    break;
                case 3:
                    $query = $query->orderBy('email', $condition['dir']);
                    break;
                case 4:
                    $query->join('core_groups', 'core_groups.id', '=', 'core_users.core_group_id')
                        ->orderBy('core_groups.name', $condition['dir']);
                    break;
            }
        }

        $recordsFilteredCount = (clone $query)->count();

        $itemsIds = (clone $query)->when(($fields['length'] ?? 0) > 0, function ($q) use ($fields) {
            $q->skip($fields['start'])->take($fields['length']);
        })->get(['core_users.id'])->pluck(['id']);

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
