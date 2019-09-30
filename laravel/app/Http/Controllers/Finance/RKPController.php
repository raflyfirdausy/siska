<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finance\RPJM;
use App\Models\Finance\RKP;

class RKPController extends Controller
{
    public function index(Request $request)
    {
        $penyelenggaraan = RKP::where('category', 'penyelenggaraan');
        $pelaksanaan = RKP::where('category', 'pelaksanaan');
        $pembinaan = RKP::where('category', 'pembinaan');
        $pemberdayaan = RKP::where('category', 'pemberdayaan');
        
        if ($request->has('q')) {
            $q = $request->input('q');
            if ($request->has('penyelenggaraan')) {
                $penyelenggaraan = $penyelenggaraan->whereHas('rpjm', function($query) use ($q) {
                    return $query->where('title', 'LIKE', "%$q%");
                })
                ->where('category', 'penyelenggaraan');
            }
            if ($request->has('pelaksanaan')) {
                $pelaksanaan = $pelaksanaan->whereHas('rpjm', function($query) use ($q) {
                    return $query->where('title', 'LIKE', "%$q%");
                })
                ->where('category', 'pelaksanaan');
            }
            if ($request->has('pembinaan')) {
                $pembinaan = $pembinaan->whereHas('rpjm', function($query) use ($q) {
                    return $query->where('title', 'LIKE', "%$q%");
                })
                ->where('category', 'pembinaan');
            }
            if ($request->has('pemberdayaan')) {
                $pemberdayaan = $pemberdayaan->whereHas('rpjm', function($query) use ($q) {
                    return $query->where('title', 'LIKE', "%$q%");
                })
                ->where('category', 'pemberdayaan');
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

        return view('keuangan.rkp.index', compact('penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan'));
    }

    public function create()
    {
        $rpjm = RPJM::oldest('title')->get();
        return view('keuangan.rkp.tambah', compact('rpjm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rpjm_id' => 'required|exists:rpjm,id',
            'description' => 'required',
            'target' => 'required',
            'category' => 'required|in:penyelenggaraan,pelaksanaan,pembinaan,pemberdayaan',
        ]);
        
        $rkp = new RKP($request->except('category'));
        $rkp->category = $request->category;
        $rkp->save();

        return redirect('rkp')->with('success', 'Penambahan RKP baru berhasil dilakukan!');
    }

    public function edit($id)
    {
        $rkp = RKP::findOrFail($id);
        $rpjm = RPJM::oldest('title')->get();

        return view('keuangan.rkp.ubah', compact('rkp', 'rpjm'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rpjm_id' => 'required|exists:rpjm,id',
            'description' => 'required',
            'target' => 'required',
        ]);

        $rkp = RKP::findOrFail($id);
        $rkp->update($request->all());
        $rkp->save();

        return redirect('rkp')->with('success', 'Pengubahan RKP berhasil dilakukan!');
    }

    public function delete($id)
    {
        $rkp = RKP::findOrFail($id);
        $rkp->delete();

        return redirect('rkp')->with('success', 'Penghapusan RKP berhasil dilakukan!');
    }
}
