<?php

namespace App\Exports\ImportFormat;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Resident;
use App\Models\Residency\Education;
use App\Models\Residency\Occupation;

class ResidentsExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
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
            'NOMOR KK',
            'ALAMAT',
            'HUBUNGAN DI KELUARGA'
        ];
    }
}
