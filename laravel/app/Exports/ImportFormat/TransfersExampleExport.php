<?php

namespace App\Exports\ImportFormat;

use App\Models\Residency\Transfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransfersExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
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
}
