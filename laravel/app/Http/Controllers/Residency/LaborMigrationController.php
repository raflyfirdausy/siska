<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Residency\LaborMigration;
use App\Models\Residency\Resident;
use App\Models\Residency\LaborBureau;
use Illuminate\Support\Facades\DB;
use App\Exports\LaborMigrationsExport;
use Maatwebsite\Excel\Facades\Excel;

class LaborMigrationController extends Controller
{
    public function index(Request $request)
    {
        $migrations = LaborMigration::with('resident');
        $bureaus = LaborBureau::oldest('name')->get();

        if ($request->has('q')) {
            $q = $request->input('q');
            $migrations = $migrations->whereHas('resident', function($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('nik', 'LIKE', "%$q%");
            });
        }
        
        $migrations = $migrations->paginate(50);

        return view('kependudukan.migrasi.index', compact('migrations', 'bureaus'));
    }

    public function store(Request $request){

        $request->validate([
            'nik' => 'required|digits:16|exists:residents,nik',
            'destination_country' => 'required',
            'duration' => 'required',
            'occupation' => 'required',
            'departure_date' => 'required',
            'labor_bureau' => 'required|exists:labor_bureaus,id'
        ]);
        
        DB::transaction(function () use ($request) {
            $resident = Resident::where('nik', $request->nik)->firstOrFail();
            LaborMigration::create([
                'resident_id' => $resident->id,
                'destination_country' => $request->destination_country,
                'duration' => $request->duration,
                'occupation' => $request->occupation,
                'departure_date' => $request->departure_date,
                'labor_bureau_id' => $request->labor_bureau,
            ]);
        });
        

        return redirect('/migrasi')->with('success', 'Penambahan data migrasi berhasil dilakukan!');
    }

    public function edit($id){
        $migration = LaborMigration::findOrFail($id);
        $bureaus = LaborBureau::oldest('name')->get();

        return view('kependudukan.migrasi.ubah', compact('migration', 'bureaus'));
    }

    public function create(){
        $bureaus = LaborBureau::oldest('name')->get();

        return view('kependudukan.migrasi.tambah', compact('bureaus'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'destination_country' => 'required',
            'duration' => 'required',
            'occupation' => 'required',
            'departure_date' => 'required',
            'labor_bureau' => 'required|exists:labor_bureaus,id'
        ]);

        DB::transaction(function () use ($request, $id) {
            $migration = LaborMigration::findOrFail($id);
            $migration->update([
                'destination_country' => $request->destination_country,
                'duration' => $request->duration,
                'occupation' => $request->occupation,
                'departure_date' => $request->departure_date,
                'labor_bureau_id' => $request->labor_bureau,
            ]);
        });
            
            return redirect('/migrasi')->with('success', 'Pengubahan data migrasi berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $migration = LaborMigration::findOrFail($id);
        $migration->delete();
        return redirect('/migrasi')->with('success', 'Penghapusan data migrasi berhasil dilakukan!');
    }
    
    public function print()
    {
        $migration = LaborMigration::with('resident')->get();
        return view('kependudukan.migrasi.cetak', compact('migration'));
    }

    public function export()
    {
        return Excel::download(new LaborMigrationsExport, 'data-migrasi-tki.xlsx');
    }
}
