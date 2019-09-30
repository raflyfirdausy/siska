<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Residency\Poverty;
use App\Models\Residency\PovertyAudit;
use App\Exports\PovertiesExport;
use Maatwebsite\Excel\Facades\Excel;

class PovertyController extends Controller
{
    public function print()
    {
        $poverties = Poverty::with('resident')->get();

        return view('kependudukan.kemiskinan.cetak', compact('poverties'));
    }

    public function index(Request $request)
    {
        $poverties =  Poverty::with('resident');
        if ($request->has('q')) {
            $q = $request->input('q');
            $poverties = $poverties->whereHas('resident', function($query) use ($q) {
                return $query->where('nik', 'LIKE', "%$q%")
                    ->orWhere('name', 'LIKE', "%$q%");
            });
        }

        $poverties = $poverties->paginate(50);

        return view('kependudukan.kemiskinan.index', compact('poverties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|exists:residents,nik',
        ]);

        $resident = Resident::where('nik', $request->nik)->firstOrFail();

        $poverty = Poverty::create([
            'resident_id' => $resident->id,
        ]);

        return redirect('/kemiskinan')->with('success', 'Penambahan data kemiskinan berhasil dilakukan!');
    }

    public function destroy(Request $request, $id)
    {
        $poverty = Poverty::findOrFail($id);

        $poverty->delete();

        return redirect('/kemiskinan')->with('success', 'Penghapusan data kemiskinan berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new PovertiesExport, 'data-kemiskinan.xlsx');
    }
}
