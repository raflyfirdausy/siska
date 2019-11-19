<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;

class SuratController extends Controller
{
    public function getSurat(Request $request)
    {
        $surat  = Surat::latest('id')->where('jenis', 'keluar');
        if ($request->input('q') != "" || $request->input('tahun') != "") {
            $q      = $request->input('q');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $surat->where(function ($query) use ($q) {
                    $query->where('nomer', 'LIKE', "%$q%")
                        ->orWhere('tanggal', 'LIKE', "%$q%")
                        ->orWhere('perihal', 'LIKE', "%$q%")
                        ->orWhere('dari', 'LIKE', "%$q%")
                        ->orWhere('type', 'LIKE', "%$q%")
                        ->orWhere('jenis', 'LIKE', "%$q%")
                        ->orWhere('nik', 'LIKE', "%$q%");
                });
            }

            if ($tahun != "") {
                $surat->where(function ($query2) use ($tahun) {
                    $query2->whereYear("tanggal", "=", $tahun);
                });
            }
        }

        $surat = $surat->paginate(10);

        $jenis  = Surat::distinct()->get(["type"]);
        $tahun  = Surat::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $type   = "Keluar";
        // die(json_encode($surat));
        return view('kesekretariatan.surat.index2', compact('surat', 'jenis', 'tahun', 'type'));
    }
}
