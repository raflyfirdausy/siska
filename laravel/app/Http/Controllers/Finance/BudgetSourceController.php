<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\BudgetSource;

class BudgetSourceController extends Controller
{
    public function index(Request $request)
    {
        $sources = BudgetSource::paginate(50);

        if ($request->has('q')) {
            $q = $request->query('q');
            $sources = BudgetSource::where('name', 'LIKE', "%$q%")->paginate(50);
        }

        return view('keuangan.sumber-anggaran.index', compact('sources'));
    }

    public function create()
    {
        return view('keuangan.sumber-anggaran.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'budget' => 'required',
        ]);

        BudgetSource::create($request->all());

        return redirect('sumber-anggaran')->with('success', 'Penambahan sumber anggaran berhasil dilakukan!');
    }

    public function edit($id)
    {
        $source = BudgetSource::findOrFail($id);

        return view('keuangan.sumber-anggaran.ubah', compact('source'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'budget' => 'required',
        ]);

        $source = BudgetSource::findOrFail($id);
        $source->fill($request->all());
        $source->save();

        return redirect('sumber-anggaran')->with('success', 'Pengubahan sumber anggaran berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $source = BudgetSource::findOrFail($id);
        $source->delete();
        
        return redirect('sumber-anggaran')->with('success', 'Penghapusan sumber anggaran berhasil dilakukan!');
    }

    public function getSource(Request $request, $name)
    {
        $source = BudgetSource::where('name', 'LIKE', "%$name%")->get();

        return $source;
    }
}
