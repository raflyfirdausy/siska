<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Residency\Resident;
use App\Models\Residency\Beneficiary;
use App\Models\Residency\BeneficiaryType;
use App\Exports\BeneficiariesExport;
use Maatwebsite\Excel\Facades\Excel;

class BeneficiaryController extends Controller
{
    public function print()
    {
        $beneficiaries = Beneficiary::with('type', 'resident')->get();

        return view('kependudukan.kemiskinan.penerima-bantuan.cetak', compact('beneficiaries'));
    }

    public function index(Request $request)
    {
        $types = BeneficiaryType::all();
        $beneficiaries = Beneficiary::with('type', 'resident');

        if ($request->has('q')) {
            $q = $request->query('q');
            $beneficiaries = $beneficiaries->whereHas('resident', function($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('nik', 'LIKE', "%$q%");
            });
        }

        $beneficiaries = $beneficiaries->paginate(50);

        return view('kependudukan.kemiskinan.penerima-bantuan.index', compact('beneficiaries', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|exists:residents,nik',
            'beneficiary_type_id' => 'required|exists:beneficiary_types,id',
        ]);

        DB::transaction(function () use ($request) {
            $resident = Resident::where('nik', $request->nik)->isNotBeneficiary()->firstOrFail();
            if (!$resident) {
                return redirect('/penerima-bantuan/tambah')->withErrors('Penduduk tersebut sudah menjadi penerima bantuan!');
            }

            Beneficiary::create([
                'resident_id' => $resident->id,
                'beneficiary_type_id' => $request->beneficiary_type_id,
            ]);

        });
        return redirect('penerima-bantuan')->with('success', 'Penambahan data penerimaan bantuan berhasil dilakukan!');
    }

    public function edit($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $types = BeneficiaryType::all();

        return view('kependudukan.kemiskinan.penerima-bantuan.ubah', compact('beneficiary', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'beneficiary_type_id' => 'required|exists:beneficiary_types,id',
        ]);

        DB::transaction(function () use ($request, $id) {
            $beneficiary = Beneficiary::findOrFail($id);
            $beneficiary->beneficiary_type_id = $request->beneficiary_type_id;

            $beneficiary->save();

        });
        return redirect('/penerima-bantuan')->with('success', 'Pengubahan data penerimaan bantuan berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiary->delete();

        return redirect('/penerima-bantuan')->with('success', 'Penghapusan data penerimaan bantuan berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new BeneficiariesExport, 'data-penerima-bantuan.xlsx');
    }
}
