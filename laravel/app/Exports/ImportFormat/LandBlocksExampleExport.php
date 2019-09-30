<?php

namespace App\Exports\ImportFormat;

use App\Models\Estate\LandBlock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LandBlocksExampleExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection() {
        return collect([
            ['', '', ''],
        ]);
    }

    public function headings(): array {
        return [
            'NO',
            'NOMOR BLOK TANAH',
            'KETERANGAN',
        ];
    }

    public function map($a): array {
        return [
            $a,
            $a,
            $a,
        ];
    }
}
