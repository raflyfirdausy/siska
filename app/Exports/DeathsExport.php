<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Death;
use App\Models\Residency\Resident;

class DeathsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Death::with('resident')->get();
    }

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

    public function map($d) : array {
        return [
            '=ROW() - 1',
            $d->resident->nik,
            $d->resident->name,
            $d->date_of_death->format('d/m/Y'),
            $d->time_of_death,
            $d->tempat_kematian,
            $d->penentu_kematian,
            $d->reporter,
            $d->hubungan_pelapor,
        ];
    }
}
