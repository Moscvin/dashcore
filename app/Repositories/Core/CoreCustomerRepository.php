<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CoreCustomerRepository extends BaseRepository
{

    public function getDataTablesFiltered($fields)
    {
        $query = clone $this->query;
        $recordsTotalCount = (clone $query)->count();

        $query->when($fields['fieldFilter'] && $fields['valueFilter'], function ($q) use ($fields) {
            switch ($fields['fieldFilter']) {
                case 'customer_name':
                    $q->where('company_name', 'like', '%' . $fields['valueFilter'] . '%')
                        ->orWhere(DB::raw("CONCAT(`name`, ' ', `surname`)"), 'like', '%' . $fields['valueFilter'] . '%');
                    break;
                case 'phone':
                    $q->where(DB::raw("CONCAT(COALESCE(`prefix_1`,''),COALESCE(`phone_1`,''),COALESCE(`prefix_2`,''),COALESCE(`phone_2`,''))"), 'LIKE', '%' . $fields['valueFilter'] . '%');
                    break;
                default:
                    $q->where($fields['fieldFilter'], 'like', '%' . $fields['valueFilter'] . '%');
                    break;
            }
        });

        foreach ($fields->order as $condition) {
            switch ($condition['column']) {
                case 0:
                    $query = $query->orderBy('core_customers.company_name', $condition['dir']);
                    break;
                case 1:
                    $query = $query->orderBy('core_customers.vat', $condition['dir']);
                    break;
                case 2:
                    $query = $query->orderBy('core_customers.code_fiscal', $condition['dir']);
                    break;
                case 3:
                    $query = $query
                        ->orderBy('core_customers.country_sl', $condition['dir'])
                        ->orderBy('core_customers.city_sl', $condition['dir'])
                        ->orderBy('core_customers.province_sl', $condition['dir']);
                    break;
                case 4:
                    $query = $query
                        ->orderBy('core_customers.prefix_1', $condition['dir'])
                        ->orderBy('core_customers.phone_1', $condition['dir'])
                        ->orderBy('core_customers.prefix_2', $condition['dir'])
                        ->orderBy('core_customers.phone_2', $condition['dir']);
                    break;
            }
        }

        $recordsFilteredCount = (clone $query)->count();

        $itemsIds = (clone $query)->when(($fields['length'] ?? 0) > 0, function ($q) use ($fields) {
            $q->skip($fields['start'])->take($fields['length']);
        })->get(['core_customers.id'])->pluck(['id']);

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
