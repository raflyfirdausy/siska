<?php

namespace App\Http\Controllers\Estate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Estate\LandCertificate;
use App\Models\Estate\LandOwner;
use App\Exports\LandCertificatesExport;
use Maatwebsite\Excel\Facades\Excel;

class LandCertificateController extends Controller
{
    public function print()
    {
        $lands = LandCertificate::with('resident', 'owners', 'owners.resident')->get();

        return view('pertanahan.sertifikat-tanah.cetak', compact('lands'));
    }

    public function index(Request $request)
    {
        $lands = LandCertificate::with('resident', 'owners', 'owners.resident');
        
        if ($request->has('q')) {
            $q = $request->input('q');

            $lands = LandCertificate::whereHas('resident', function($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })
            ->orWhere('number', 'LIKE', "%$q%");
        }
        
        $lands = $lands->paginate(50);

        return view('pertanahan.sertifikat-tanah.index', compact('lands'));
    }

    public function show($id)
    {
        $land = LandCertificate::with('resident', 'owners', 'owners.resident')->where('id', $id)->firstOrFail();

        return view('pertanahan.sertifikat-tanah.lihat', compact('land'));
    }

    public function create()
    {
        return view('pertanahan.sertifikat-tanah.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_owner_nik' => 'required|digits:16',
            'number' => 'required',
            'past_owner_nik' => 'nullable|array',
            'past_owner_year' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $resident = Resident::where('nik', $request->current_owner_nik)->firstOrFail();
            $certificate = LandCertificate::create([
                'resident_id' => $resident->id,
                'number' => $request->number,
            ]);

            if ($request->has('past_owner_nik') && $request->filled('past_owner_nik.0')) {
                for ($i = 0; $i < count($request->past_owner_nik); $i++) {
                    $ownerResident = Resident::where('nik', $request->past_owner_nik[$i])->firstOrFail();

                    LandOwner::create([
                        'resident_id' => $ownerResident->id,
                        'land_certificate_id' => $certificate->id,
                        'year' => $request->past_owner_year[$i],
                    ]);
                }
            }
        });

        return redirect('/sertifikat-tanah')->with('success', 'Penambahan data sertifikat tanah berhasil dilakukan!');
    }

    public function edit($id)
    {
        $land = LandCertificate::with('resident', 'owners', 'owners.resident')->where('id', $id)->firstOrFail();

        return view('pertanahan.sertifikat-tanah.ubah', compact('land'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required',
            'past_owner_nik' => 'nullable|array',
            'past_owner_year' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $id) {
            $certificate = LandCertificate::findOrFail($id);

            $certificate->owners()->delete();
            if ($request->has('past_owner_nik')) {

                for ($i = 0; $i < count($request->past_owner_nik); $i++) {
                    $ownerResident = Resident::where('nik', $request->past_owner_nik[$i])->firstOrFail();

                    LandOwner::create([
                        'resident_id' => $ownerResident->id,
                        'land_certificate_id' => $certificate->id,
                        'year' => $request->past_owner_year[$i],
                    ]);
                }
            }
            $certificate->update($request->only('number'));
        });

        return redirect('/sertifikat-tanah')->with('success', 'Pengubahan data sertifikat tanah berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $land = LandCertificate::with('owners')->where('id', $id)->firstOrFail();
        $land->owners()->delete();

        $land->delete();

        return redirect('/sertifikat-tanah')->with('success', 'Penghapusan data sertifikat tanah berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new LandCertificatesExport, 'data-sertifikat-tanah.xlsx');
    }
}
