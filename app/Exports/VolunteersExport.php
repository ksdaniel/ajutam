<?php

namespace App\Exports;

use App\Volunteer;
use Maatwebsite\Excel\Concerns\FromCollection;


use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VolunteersExport implements  FromCollection,ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Volunteer::all();
    }


}
