<?php

namespace App\Exports;

use App\Models\Residency\Transfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransfersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transfer::with('resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'TANGGAL KEPINDAHAN',
            'ALAMAT BARU',
            'ALASAN',
        ];
    }

    public function map($t) : array {
        return [
            '=ROW() - 1',
            $t->resident->nik,
            $t->resident->name,
            $t->date_of_transfer->format('d/m/Y'),
            $t->destination_address,
            $t->alasan,
        ];
    }
}
