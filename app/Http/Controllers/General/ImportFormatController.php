<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\ImportFormat\BeneficiariesExampleExport;
use App\Exports\ImportFormat\BirthsExampleExport;
use App\Exports\ImportFormat\DeathsExampleExport;
use App\Exports\ImportFormat\LaborMigrationsExampleExport;
use App\Exports\ImportFormat\LandBlocksExampleExport;
use App\Exports\ImportFormat\LandCertificatesExampleExport;
use App\Exports\ImportFormat\LandClassesExampleExport;
use App\Exports\ImportFormat\NewcomersExampleExport;
use App\Exports\ImportFormat\PovertiesExampleExport;
use App\Exports\ImportFormat\ResidentsExampleExport;
use App\Exports\ImportFormat\TransfersExampleExport;
use Maatwebsite\Excel\Facades\Excel;

class ImportFormatController extends Controller
{
    public function beneficiariesFormat()
    {
        return Excel::download(new BeneficiariesExampleExport, 'format-import-penerima-bantuan.xlsx');
    }
    
    public function birthsFormat()
    {
        return Excel::download(new BirthsExampleExport, 'format-import-kelahiran.xlsx');
    }

    public function deathsFormat()
    {
        return Excel::download(new DeathsExampleExport, 'format-import-kematian.xlsx');
    }

    public function laborMigrationsFormat()
    {
        return Excel::download(new LaborMigrationsExampleExport, 'format-import-migrasi-tki.xlsx');
    }

    public function landBlocksFormat()
    {
        return Excel::download(new LandBlocksExampleExport, 'format-import-blok-tanah.xlsx');
    }

    public function landCertificatesFormat()
    {
        return Excel::download(new LandCertificatesExampleExport, 'format-import-sertifikat-tanah.xlsx');
    }

    public function landClassesFormat()
    {
        return Excel::download(new LandClassesExampleExport, 'format-import-kelas-tanah.xlsx');
    }

    public function newcomersFormat()
    {
        return Excel::download(new NewcomersExampleExport, 'format-import-pendatang.xlsx');
    }

    public function povertiesFormat()
    {
        return Excel::download(new PovertiesExampleExport, 'format-import-kemiskinan.xlsx');
    }

    public function residentsFormat()
    {
        return Excel::download(new ResidentsExampleExport, 'format-import-penduduk.xlsx');
    }

    public function transfersFormat()
    {
        return Excel::download(new TransfersExampleExport, 'format-import-kepindahan.xlsx');
    }

}
