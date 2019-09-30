<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\VillageBusiness;

class VillageBusinessController extends Controller
{
    public function index(Request $request)
    {
        $businesses = VillageBusiness::paginate(50);

        if ($request->has('q')) {
            $q = $request->query('q');
            $businesses = VillageBusiness::where('name', 'LIKE', "%$q%")->paginate(50);
        }

        return view('keuangan.usaha-desa.index', compact('businesses'));
    }

    public function create()
    {
        return view('keuangan.usaha-desa.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'budget' => 'required',
        ]);

        VillageBusiness::create($request->all());

        return redirect('usaha-desa')->with('success', 'Penambahan usaha desa berhasil dilakukan!');
    }

    public function edit($id)
    {
        $business = VillageBusiness::findOrFail($id);

        return view('keuangan.usaha-desa.ubah', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'budget' => 'required',
        ]);

        $business = VillageBusiness::findOrFail($id);
        $business->fill($request->all());
        $business->save();

        return redirect('usaha-desa')->with('success', 'Pengubahan usaha desa berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $business = VillageBusiness::findOrFail($id);
        $business->delete();
        
        return redirect('usaha-desa')->with('success', 'Penghapusan usaha desa berhasil dilakukan!');
    }

    public function getBusiness(Request $request, $name)
    {
        $business = VillageBusiness::where('name', 'LIKE', "%$name%")->get();

        return $business;
    }
}
