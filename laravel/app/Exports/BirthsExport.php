<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Residency\Birth;

class BirthsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Birth::with('father', 'mother', 'resident')->whereHas('resident', function($q) {
            return $q->canBeDisplayed();
        })->get();
    }

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

    public function map($b) : array {
        return [
            '=ROW() - 1',
            $b->resident->name,
            $b->father ? $b->father->name : '-',
            $b->mother ? $b->mother->name : '-',
            $b->weight . 'kg',
            $b->height . 'cm',
            $b->place_of_birth,
            $b->date_of_birth->format('d/m/Y'),
            $b->time_of_birth,
            $b->child_number,
            $b->tempat_bersalin,
            $b->pembantu_persalinan,
            $b->reporter,
            $b->hubungan_pelapor,
            $b->first_witness,
            $b->second_witness,
        ];
    }
}
