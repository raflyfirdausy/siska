<?php

namespace App\Exports\ImportFormat;

use App\Models\Estate\LandClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LandClassesExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'KODE',
            'HARGA',
        ];
    }
}
