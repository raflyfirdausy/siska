<?php

namespace App\Exports;

use App\Models\Residency\Newcomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewcomersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Newcomer::with('resident', 'resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NOMOR KK',
            'NIK',
            'NAMA',
            'ALAMAT ASAL',
            'ALAMAT SAAT INI',
        ];
    }

    public function map($n) : array {
        return [
            '=ROW() - 1',
            $n->resident->family_member->family->no_kk,
            $n->resident->nik,
            $n->resident->name,
            $n->resident->family_member->family->alamat_lengkap,
            $n->alamat_lengkap,
        ];
    }
}
