<?php

namespace App\Http\Controllers\Estate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Estate\LandBlock;
use App\Exports\LandBlocksExport;
use Maatwebsite\Excel\Facades\Excel;

class LandBlockController extends Controller
{
    public function print()
    {
        $landBlocks = LandBlock::all();

        return view('pertanahan.blok-tanah.cetak', compact('landBlocks'));
    }

    public function index(Request $request)
    {
        $landBlocks = LandBlock::paginate(50);

        if ($request->has('q')) {
            $q = $request->input('q');

            $landBlocks = LandBlock::where('number', 'LIKE', "%$q%")
                ->orWhere('note', 'LIKE', "%$q%")
                ->paginate(50);
        }

        return view('pertanahan.blok-tanah.index', compact('landBlocks'));
    }

    public function create()
    {
        return view('pertanahan.blok-tanah.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'note' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            LandBlock::create([
                'number' => $request->number,
                'note' => $request->note
            ]);
        });

        return redirect('blok-tanah')->with('success', 'Penambahan data blok tanah berhasil dilakukan!');
    }

    public function edit(Request $request, $id)
    {
        $landBlock = LandBlock::findOrFail($id);

        return view('pertanahan.blok-tanah.ubah', compact('landBlock'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required',
            'note' => 'required',
        ]);

        DB::transaction(function () use ($request, $id) {
            $landBlock = LandBlock::findOrFail($id);
            $landBlock->update($request->all());
        });
        return redirect('blok-tanah')->with('success', 'Pengubahan data blok tanah berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $landBlock = LandBlock::findOrFail($id);
        $landBlock->delete();

        return redirect('blok-tanah')->with('success', 'Penghapusan data blok tanah berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new LandBlocksExport, 'data-blok-tanah.xlsx');
    }
}
