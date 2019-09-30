<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Finance\RPJM;
use App\Models\Finance\BudgetSource;
use App\Models\Finance\Execution;
use App\Models\Finance\ExecutionDocumentation;

class ExecutionController extends Controller
{
    public function index(Request $request)
    {
        $penyelenggaraan = Execution::where('category', 'penyelenggaraan');
        $pelaksanaan = Execution::where('category', 'pelaksanaan');
        $pembinaan = Execution::where('category', 'pembinaan');
        $pemberdayaan = Execution::where('category', 'pemberdayaan');
        
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

        return view('keuangan.pelaksanaan.index', compact('penyelenggaraan', 'pelaksanaan', 'pembinaan', 'pemberdayaan'));
    }

    public function create()
    {
        $rpjm = RPJM::oldest('title')->get();
        $sources = BudgetSource::oldest('name')->get();

        return view('keuangan.pelaksanaan.tambah', compact('rpjm', 'sources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rpjm_id' => 'required|exists:rpjm,id',
            'budget_source_id' => 'required|exists:budget_sources,id',
            'documentations' => 'nullable',
            'status' => 'required|in:sesuai,tidak',
            'category' => 'required|in:penyelenggaraan,pelaksanaan,pembinaan,pemberdayaan',
        ]);
        
        $execution = new Execution($request->except('category', 'documentations'));
        $execution->category = $request->category;
        $execution->save();

        if ($request->hasFile('documentations')) {
            foreach ($request->documentations as $d) {
                $photoName = $d->hashName();
                $url = $d->storeAs('uploaded/images', $photoName, 'public');
                ExecutionDocumentation::create([
                    'execution_id' => $execution->id, 
                    'url' => $url,
                ]);
            }
        }

        return redirect('pelaksanaan')->with('success', 'Penambahan pelaksanaan baru berhasil dilakukan!');
    }

    public function edit($id)
    {
        $execution = Execution::findOrFail($id);
        $rpjm = RPJM::oldest('title')->get();
        $sources = BudgetSource::oldest('name')->get();

        return view('keuangan.pelaksanaan.ubah', compact('execution', 'rpjm', 'sources'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rpjm_id' => 'required|exists:rpjm,id',
            'budget_source_id' => 'required|exists:budget_sources,id',
            'documentations' => 'nullable',
            'status' => 'required|in:sesuai,tidak',
        ]);
        
        $execution = Execution::findOrFail($id);
        $execution->update($request->except('category', 'uploaded', 'documentations'));
        $execution->save();
        
        $deletedUpload = $execution->documentations()->whereNotIn('id', $request->has('uploaded') ? $request->uploaded : [])->get();
        
        foreach ($deletedUpload as $d) {
            Storage::disk('public')->delete($d->url);
            $d->delete();
        }

        if ($request->hasFile('documentations')) {
            foreach ($request->documentations as $d) {
                $photoName = $d->hashName();
                $url = $d->storeAs('uploaded/images', $photoName, 'public');
                ExecutionDocumentation::create([
                    'execution_id' => $execution->id, 
                    'url' => $url,
                ]);
            }
        }

        return redirect('pelaksanaan')->with('success', 'Pengubahan pelaksanaan berhasil dilakukan!');
    }

    public function delete($id)
    {
        $execution = Execution::findOrFail($id);
        foreach ($execution->documentations as $d) {
            Storage::disk('public')->delete($d->url);
            $d->delete();
        }

        $execution->delete();

        return redirect('pelaksanaan')->with('success', 'Penghapusan pelaksanaan berhasil dilakukan!');
    }
}
