<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Resident;
use App\Models\Residency\Education;
use App\Models\Residency\Occupation;

class ResidentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Resident::with('education', 'occupation')->canBeDisplayed()->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'KEWARGANEGARAAN',
            'JENIS KELAMIN',
            'GOLONGAN DARAH',
            'AGAMA',
            'STATUS PERKAWINAN',
            'STATUS KEPENDUDUKAN',
            'PENDIDIKAN TERAKHIR',
            'PEKERJAAN',
        ];
    }

    public function map($r) : array {
        return [
            '=ROW() - 1',
            strval($r->nik),
            $r->name,
            $r->birthday->format('d/m/Y'),
            $r->birth_place,
            $r->kewarganegaraan,
            $r->jenkel,
            $r->goldar,
            $r->agama,
            $r->status_kawin,
            $r->status_kependudukan,
            $r->education->name,
            $r->occupation->name,
        ];
    }
}
