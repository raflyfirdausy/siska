<?php

namespace App\Exports;

use App\Models\Estate\LandCertificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LandCertificatesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LandCertificate::with('resident', 'owners', 'owners.resident')->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NOMOR SERTIFIKAT',
            'PEMILIK SAAT INI',
            'PEMILIK SEBELUMNYA',
        ];
    }

    public function map($l) : array {
        return [
            '=ROW() - 1',
            $l->number,
            $l->resident->name,
            $l->pemilik_sebelumnya,
        ];
    }
}
