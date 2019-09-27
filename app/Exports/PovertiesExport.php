<?php

namespace App\Exports;

use App\Models\Residency\Poverty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PovertiesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Poverty::with('resident')->whereHas('resident', function($q) {
            return $q->canBeDisplayed();
        })->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA'
        ];
    }

    public function map($f) : array {
        return [
            '=ROW() - 1',
            $f->no_kk,
            $f->resident->nik,
            $f->resident->name,
        ];
    }
}
