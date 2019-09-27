<?php

namespace App\Exports\ImportFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Death;
use App\Models\Residency\Resident;

class DeathsExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA MENDIANG',
            'TANGGAL KEMATIAN',
            'WAKTU KEMATIAN',
            'TEMPAT KEMATIAN',
            'PENENTU KEMATIAN',
            'PELAPOR',
            'HUBUNGAN PELAPOR',
        ];
    }
}
