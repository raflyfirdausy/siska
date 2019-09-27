<?php

namespace App\Exports;

use App\Models\Estate\LandClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LandClassesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LandClass::all();
    }

    public function headings(): array {
        return [
            'NO',
            'KODE',
            'HARGA',
        ];
    }

    public function map($c) : array {
        return [
            '=ROW() - 1',
            $c->code,
            $c->price,
        ];
    }
}
