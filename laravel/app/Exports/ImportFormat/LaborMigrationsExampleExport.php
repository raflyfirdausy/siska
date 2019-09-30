<?php

namespace App\Exports\ImportFormat;

use App\Models\Residency\LaborMigration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaborMigrationsExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NEGARA TUJUAN',
            'PEKERJAAN',
            'TANGGAL BERANGKAT',
            'TANGGAL PULANG',
            'PPTKI'
        ];
    }
}
