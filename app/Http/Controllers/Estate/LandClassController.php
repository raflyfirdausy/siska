<?php

namespace App\Http\Controllers\Estate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Estate\LandClass;
use App\Exports\LandClassesExport;
use Maatwebsite\Excel\Facades\Excel;

class LandClassController extends Controller
{
    public function print()
    {
        $landClasses = LandClass::all();

        return view('pertanahan.kelas-tanah.cetak', compact('landClasses'));
    }

    public function index(Request $request)
    {
        $landClasses = LandClass::paginate(50);

        if ($request->has('q')) {
            $q = $request->input('q');

            $landClasses = LandClass::where('code', 'LIKE', "%$q%")
                ->paginate(50);
        }

        return view('pertanahan.kelas-tanah.index', compact('landClasses'));
    }

    public function create()
    {
        return view('pertanahan.kelas-tanah.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'price' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            LandClass::create($request->all());
        });

        return redirect('kelas-tanah')->with('success', 'Penambahan data kelas tanah berhasil dilakukan!');
    }

    public function edit(Request $request, $id)
    {
        $landClass = LandClass::findOrFail($id);

        return view('pertanahan.kelas-tanah.ubah', compact('landClass'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'price' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $id) {
            $landClass = LandClass::findOrFail($id);
            $landClass->update($request->all());
        });

        return redirect('kelas-tanah')->with('success', 'Pengubahan data kelas tanah berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $landClass = LandClass::findOrFail($id);
        $landClass->delete();

        return redirect('kelas-tanah')->with('success', 'Penghapusan data kelas tanah berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new LandClassesExport, 'data-kelas-tanah.xlsx');
    }
}
