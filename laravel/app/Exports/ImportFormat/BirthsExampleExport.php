<?php

namespace App\Exports\ImportFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Birth;

class BirthsExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'NAMA BAYI',
            'NAMA AYAH',
            'NAMA IBU',
            'BERAT',
            'TINGGI',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'WAKTU LAHIR',
            'ANAK KE', 
            'TEMPAT PERSALINAN',
            'PEMBANTU PERSALINAN',
            'PELAPOR',
            'HUBUNGAN PELAPOR',
            'SAKSI PERTAMA',
            'SAKSI KEDUA',
        ];
    }
}
