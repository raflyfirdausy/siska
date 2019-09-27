<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Family;

class FamiliesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Family::with('members', 'members.resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NOMOR KK',
            'KEPALA KELUARGA',
            'ALAMAT',
        ];
    }

    public function map($f) : array {
        return [
            '=ROW() - 1',
            $f->no_kk,
            $f->familyHead()->name,
            $f->alamat_lengkap,
        ];
    }
}
