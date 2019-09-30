<?php

namespace App\Exports;

use App\Models\Residency\Beneficiary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BeneficiariesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Beneficiary::with('resident', 'type')->whereHas('resident', function($q) {
            return $q->canBeDisplayed();
        })->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'JENIS BANTUAN',
        ];
    }

    public function map($f) : array {
        return [
            '=ROW() - 1',
            $f->resident->nik,
            $f->resident->name,
            $f->type->name,
        ];
    }
}
