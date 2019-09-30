<?php

namespace App\Exports\ImportFormat;

use App\Models\Residency\Beneficiary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BeneficiariesExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'JENIS BANTUAN',
        ];
    }
}
