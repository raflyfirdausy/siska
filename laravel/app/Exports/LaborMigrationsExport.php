<?php

namespace App\Exports;

use App\Models\Residency\LaborMigration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaborMigrationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LaborMigration::with('resident', 'bureau')->whereHas('resident', function($q) {
            return $q->canBeDisplayed();
        })->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'NEGARA TUJUAN',
            'PEKERJAAN',
            'TANGGAL BERANGKAT',
            'TANGGAL PULANG',
            'PPTKI'
        ];
    }

    public function map($l) : array {
        return [
            '=ROW() - 1',
            $l->resident->nik,
            $l->resident->name,
            $l->destination_country,
            $l->occupation,
            $l->departure_date->format('d/m/Y'),
            $l->duration->format('d/m/Y'),
            $l->bureau->name,
        ];
    }
}
