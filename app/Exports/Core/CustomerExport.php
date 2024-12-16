<?php

namespace App\Exports\Core;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($customers, $fileName)
    {
        $this->customers = $customers;
        $this->fileName = $fileName;
    }

    public function view(): View
    {
        $customers = $this->customers;
        $headerTitle = $this->fileName;
        return view('excel.customer.index', compact('customers', 'headerTitle'));
    }
}
