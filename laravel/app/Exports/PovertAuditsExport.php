<?php

namespace App\Exports;

use App\Models\Residency\PovertyAudit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PovertyAuditsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PovertyAudit::with('resident')->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'TANGGAL',
            'HASIL',
        ];
    }

    public function map($a) : array {
        return [
            '=ROW() - 1',
            $a->resident->nik,
            $a->resident->name,
            $a->created_at->format('d/m/Y'),
            $a->result == 'miskin' ? 'Dinyatakan Miskin' : 'Tidak Miskin',
        ];
    }
}
