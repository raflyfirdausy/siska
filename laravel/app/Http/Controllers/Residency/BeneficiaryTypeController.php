<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Residency\BeneficiaryType;

class BeneficiaryTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = BeneficiaryType::paginate(50);

        if ($request->has('q')) {
            $q = $request->query('q');
            $types = BeneficiaryType::where('name', 'LIKE', "%$q%")->paginate(50);
        }

        return view('kependudukan.kemiskinan.jenis-bantuan.index', compact('types'));
    }

    public function create()
    {
        return view('kependudukan.kemiskinan.jenis-bantuan.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        BeneficiaryType::create($request->all());

        return redirect('jenis-bantuan')->with('success', 'Penambahan jenis bantuan berhasil dilakukan!');
    }

    public function edit($id)
    {
        $type = BeneficiaryType::findOrFail($id);

        return view('kependudukan.kemiskinan.jenis-bantuan.ubah', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $type = BeneficiaryType::findOrFail($id);
        $type->fill($request->all());
        $type->save();

        return redirect('jenis-bantuan')->with('success', 'Pengubahan jenis bantuan berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $type = BeneficiaryType::findOrFail($id);
        $type->delete();
        
        return redirect('jenis-bantuan')->with('success', 'Penghapusan jenis bantuan berhasil dilakukan!');
    }
}
