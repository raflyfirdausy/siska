<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finance\RPJM;

class RPJMController extends Controller
{
    public function index(Request $request)
    {
        $years = RPJM::select('year')
            ->groupBy('year')
            ->get()
            ->pluck('year');

        $penyelenggaraan = RPJM::where('category', 'penyelenggaraan');
        $pelaksanaan = RPJM::where('category', 'pelaksanaan');
        $pembinaan = RPJM::where('category', 'pembinaan');
        $pemberdayaan = RPJM::where('category', 'pemberdayaan');
        
        if ($request->has('q')) {
            $q = $request->input('q');
            if ($request->has('penyelenggaraan')) {
                $penyelenggaraan = $penyelenggaraan->where('title', 'LIKE', "%$q%")
                    ->where('category', 'penyelenggaraan');
            }
            if ($request->has('pelaksanaan')) {
                $pelaksanaan = $pelaksanaan->where('title', 'LIKE', "%$q%")
                    ->where('category', 'pelaksanaan');
            }
            if ($request->has('pembinaan')) {
                $pembinaan = $pembinaan->where('title', 'LIKE', "%$q%")
                    ->where('category', 'pembinaan');
            }
            if ($request->has('pemberdayaan')) {
                $pemberdayaan = $pemberdayaan->where('title', 'LIKE', "%$q%")
                    ->where('category', 'pemberdayaan');
            }
        }
        if ($request->has('tahun')) {
            $year = $request->input('tahun');
            if ($request->has('penyelenggaraan')) {
                $penyelenggaraan = $penyelenggaraan->where('year', $year);
            }
            if ($request->has('pelaksanaan')) {
                $pelaksanaan = $pelaksanaan->where('year', $year);
            }
            if ($request->has('pembinaan')) {
                $pembinaan = $pembinaan->where('year', $year);
            }
            if ($request->has('pemberdayaan')) {
                $pemberdayaan = $pemberdayaan->where('year', $year);
            }
        }

        $penyelenggaraan = $penyelenggaraan->paginate(50);
        $pelaksanaan = $pelaksanaan->paginate(50);
        $pembinaan = $pembinaan->paginate(50);
        $pemberdayaan = $pemberdayaan->paginate(50);

        $penyelenggaraan->setPageName('penyelenggaraan');
        $pelaksanaan->setPageName('pelaksanaan');
        $pembinaan->setPageName('pembinaan');
        $pemberdayaan->setPageName('pemberdayaan');

        return view('keuangan.rpjm.index', compact('years', 'penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan'));
    }

    public function create()
    {
        return view('keuangan.rpjm.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required|in:penyelenggaraan,pelaksanaan,pembinaan,pemberdayaan',
            'year' => 'required|digits:4',
        ]);

        $rpjm = new RPJM($request->except('category'));
        $rpjm->category = $request->category;
        $rpjm->save();

        return redirect('rpjm')->with('success', 'Penambahan RPJM baru berhasil dilakukan!');
    }

    public function edit($id)
    {
        $rpjm = RPJM::findOrFail($id);

        return view('keuangan.rpjm.ubah', compact('rpjm'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'year' => 'required|digits:4'
        ]);

        $rpjm = RPJM::findOrFail($id);
        $rpjm->update($request->all());
        $rpjm->save();

        return redirect('rpjm')->with('success', 'Pengubahan RPJM berhasil dilakukan!');
    }

    public function delete($id)
    {
        $rpjm = RPJM::findOrFail($id);
        $rpjm->rkp()->delete();
        $rpjm->apbd()->delete();
        $rpjm->execution()->delete();
        $rpjm->delete();

        return redirect('rpjm')->with('success', 'Penghapusan RPJM berhasil dilakukan!');
    }

    public function getRpjm(Request $request, $title)
    {
        $rpjm = RPJM::where('title', 'LIKE', "%$title%");

        if ($request->filled('kategori')) {
            $rpjm = $rpjm->where('category', $request->input('kategori'));
        }

        $rpjm = $rpjm->get();

        return $rpjm;
    }
}
