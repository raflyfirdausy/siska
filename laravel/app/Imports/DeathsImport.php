<?php

namespace App\Imports;

use App\Models\Residency\Death;
use App\Models\Residency\Resident;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Carbon\Carbon;

class DeathsImport implements ToModel, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use SkipsFailures, SkipsErrors;

    public function model(array $row)
    {
        $resident = Resident::where('nik', $row['NIK'])->first();
        return new Death([
            'resident_id' => $resident->id,
            'date_of_death' => Carbon::createFromFormat('d/m/Y', $row['TANGGAL KEMATIAN']),
            'time_of_death' => $row['WAKTU KEMATIAN'],
            'place_of_death' => $row['TEMPAT KEMATIAN'],
            'cause_of_death' => $row['PENYEBAB'],
            'determinant' => $row['PENENTU KEMATIAN'],
            'reporter' => $row['PELAPOR'],
            'reporter_relation' => $row['HUBUNGAN PELAPOR'],
        ]);
    }
}
