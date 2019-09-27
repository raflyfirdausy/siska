<?php

namespace App\Exports;

use App\Models\Estate\LandBlock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LandBlocksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LandBlock::all();
    }

    public function headings(): array {
        return [
            'NO',
            'NOMOR BLOK TANAH',
            'KETERANGAN',
        ];
    }

    public function map($b) : array {
        return [
            '=ROW() - 1',
            $b->number,
            $b->note,
        ];
    }
}
