<?php

namespace App\Exports\ImportFormat;

use App\Models\Estate\LandCertificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LandCertificatesExampleExport implements WithHeadings, WithMapping, ShouldAutoSize
{
    public function headings(): array {
        return [
            'NO',
            'NOMOR SERTIFIKAT',
            'PEMILIK SAAT INI',
            'PEMILIK SEBELUMNYA',
        ];
    }
}
