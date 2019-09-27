<?php

namespace App\Exports;

use App\Models\Residency\Resident;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class DPTExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ageLegalVote = Carbon::today()->subYears(17);

        return Resident::where('birthday', '<=', $ageLegalVote)
            ->canBeDisplayed()
            ->get();
    }

    public function headings(): array {
        return [
            'NO',
            'NIK',
            'NAMA',
            'JENIS KELAMIN',
            'TANGGAL LAHIR',
            'UMUR',
            'PENDIDIKAN TERAKHIR',
            'PEKERJAAN',
        ];
    }

    public function map($r): array {
        return [
            '=ROW() - 1',
            strval($r->nik),
            $r->name,
            $r->jenkel,
            $r->birthday->format('d/m/Y'),
            $r->birthday->age,
            $r->education->name,
            $r->occupation->name,
        ];
    }
}
