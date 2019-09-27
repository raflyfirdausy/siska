<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finance\VillageBusiness;
use App\Models\Finance\RPJM;
use App\Models\Finance\APBD;

class APBDController extends Controller
{
    public function index(Request $request)
    {
        $penyelenggaraan = APBD::where('category', 'penyelenggaraan');
        $pelaksanaan = APBD::where('category', 'pelaksanaan');
        $pembinaan = APBD::where('category', 'pembinaan');
        $pemberdayaan = APBD::where('category', 'pemberdayaan');
        
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
                ->orWhereHas('business', function($query) use ($q) {
                    return $query->where('name', 'LIKE', "%$q%");
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

        return view('keuangan.apbd.index', compact('penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan'));
    }

    public function create(Request $request)
    {
        if (!$request->has('kategori') || !in_array($request->input('kategori'), ['penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan',])) {
            abort(404);
        }
        $rpjm = RPJM::oldest('title')->get();
        $businesses = VillageBusiness::oldest('name')->get();

        return view('keuangan.apbd.tambah', compact('businesses', 'rpjm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:penyelenggaraan,pelaksanaan,pembinaan,pemberdayaan',
            'rpjm_id' => 'required|exists:rpjm,id',
            'budget' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        switch ($request->category) {
            case 'penyelenggaraan':
                break;
            case 'pelaksanaan':
                $request->validate([
                    'participants' => 'required|numeric',
                    'building_area' => 'required|numeric',
                ]);
                break;
            case 'pembinaan':
                $request->validate([
                    'participants' => 'required|numeric',
                ]);
                break;
            case 'pemberdayaan':
                $request->validate([
                    'participants' => 'required|numeric',
                    'village_business_id' => 'required|exists:village_businesses,id',
                ]);
                break;
        }

        
        $apbd = new APBD($request->except('category'));
        $apbd->category = $request->category;
        $apbd->save();

        return redirect('apbd')->with('success', 'Penambahan APBD baru berhasil dilakukan!');
    }

    public function edit($id)
    {
        $apbd = APBD::findOrFail($id);
        $rpjm = RPJM::oldest('title')->get();
        $businesses = VillageBusiness::oldest('name')->get();

        return view('keuangan.apbd.ubah', compact('apbd', 'rpjm', 'businesses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rpjm_id' => 'required|exists:rpjm,id',
            'budget' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $apbd = APBD::findOrFail($id);

        switch ($apbd->category) {
            case 'penyelenggaraan':
                break;
            case 'pelaksanaan':
                $request->validate([
                    'participants' => 'required|numeric',
                    'building_area' => 'required|numeric',
                ]);
                break;
            case 'pembinaan':
                $request->validate([
                    'participants' => 'required|numeric',
                ]);
                break;
            case 'pemberdayaan':
                $request->validate([
                    'participants' => 'required|numeric',
                    'village_business_id' => 'required|exists:village_businesses,id',
                ]);
                break;
        }

        $apbd->update($request->all());
        $apbd->save();

        return redirect('apbd')->with('success', 'Pengubahan APBD berhasil dilakukan!');
    }

    public function delete($id)
    {
        $apbd = APBD::findOrFail($id);
        $apbd->delete();

        return redirect('apbd')->with('success', 'Penghapusan APBD berhasil dilakukan!');
    }
}
