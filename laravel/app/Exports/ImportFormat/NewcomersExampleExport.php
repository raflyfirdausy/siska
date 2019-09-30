<?php

namespace App\Exports\ImportFormat;

use App\Models\Residency\Newcomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewcomersExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'NOMOR KK',
            'NIK',
            'NAMA',
            'ALAMAT ASAL',
            'ALAMAT SAAT INI',
        ];
    }
}
