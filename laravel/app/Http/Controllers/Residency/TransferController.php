<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Residency\Transfer;
use App\Models\Residency\Family;
use App\Models\Territory;
use App\Exports\TransfersExport;
use Maatwebsite\Excel\Facades\Excel;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $transfers = Transfer::with(['resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])->latest('id');

        if ($request->has('q')) {
            $q = $request->input('q');
            $transfers = $transfers->whereHas('resident', function($query) use ($q) {
                return $query->where('nik', 'LIKE', '%'.$q.'%')
                    ->orWhere('name', 'LIKE', '%'.$q.'%');
            });
        }

        $transfers = $transfers->paginate(50);

        return view('kependudukan.kepindahan.index', compact('transfers'));
    }

    public function print()
    {
        $transfers = Transfer::with(['resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])->get();

        return view('kependudukan.kepindahan.cetak', compact('transfers'));
    }

    public function create()
    {
        $provinces = Territory::where('id', 'LIKE', '__')->get();
        return view('kependudukan.kepindahan.tambah', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transfer_type' => 'required|in:1,2,3',
            'reason' => 'required|in:pekerjaan,pendidikan,keamanan,kesehatan,perumahan,keluarga,lainnya',
            'date_of_transfer' => 'required',
            'destination_address' => 'required',
            'no_kk' => 'nullable',
            'resident_id' => 'nullable',
            'nik' => 'nullable',
            'province' => 'required|exists:territories,id',
            'district' => 'required|exists:territories,id',
            'sub_district' => 'required|exists:territories,id',
            'village' => 'required|exists:territories,id',
            'confirm' => 'required',
        ]);

        $dateOfTransfer = Carbon::createFromFormat('d/m/Y', $request->date_of_transfer);
        $province = Territory::find($request->province);
        $district = Territory::find($request->district);
        $sub_district = Territory::find($request->sub_district);
        $village = Territory::find($request->village);

        $transferType = intval($request->transfer_type);
        if ($transferType == 1) {
            $request->validate([
                'no_kk' => 'required|digits:16|exists:families,no_kk',
            ]);
            $family = Family::with(['members', 'members.resident'])
                ->where('no_kk', $request->no_kk)->firstOrFail();
            DB::transaction(function () use ($request, $family, $dateOfTransfer, $province, $district, $sub_district, $village) {
                foreach ($family->members as $m) {
                    $resident = $m->resident;
                    $transfer = Transfer::create([
                        'resident_id' => $resident->id,
                        'date_of_transfer' => $dateOfTransfer,
                        'destination_address' => $request->destination_address,
                        'reason' => $request->reason,
                        'province' => $province->id,
                        'district' => $district->id,
                        'sub_district' => $sub_district->id,
                        'village' => $village->id,
                    ]);
                }
            });
        }
        else if ($transferType == 2) {
            $request->validate([
                'resident_id' => 'required|array',
            ]);

            $residents = Resident::findOrFail($request->resident_id);
            DB::transaction(function () use ($request, $residents, $dateOfTransfer, $province, $district, $sub_district, $village) {
                foreach ($residents as $r) {
                    $transfer = Transfer::create([
                        'resident_id' => $r->id,
                        'date_of_transfer' => $dateOfTransfer,
                        'destination_address' => $request->destination_address,
                        'reason' => $request->reason,
                        'province' => $province->id,
                        'district' => $district->id,
                        'sub_district' => $sub_district->id,
                        'village' => $village->id,
                    ]);
                }
            });
        }
        else if ($transferType == 3) {
            $request->validate([
                'nik' => 'required|digits:16',
            ]);

            $resident = Resident::where('nik', $request->nik)->firstOrFail();

            DB::transaction(function () use ($request, $resident, $dateOfTransfer, $province, $district, $sub_district, $village) {
                $transfer = Transfer::create([
                    'resident_id' => $resident->id,
                    'date_of_transfer' => $dateOfTransfer,
                    'destination_address' => $request->destination_address,
                    'reason' => $request->reason,
                    'province' => $province->id,
                    'district' => $district->id,
                    'sub_district' => $sub_district->id,
                    'village' => $village->id,
                ]);
            });
        }

        return redirect('/kepindahan')->with('success', 'Penambahkan data kepindahan baru berhasil dilakukan!');
    }

    public function edit($id)
    {
        $transfer = Transfer::findOrFail($id);
        $resident = $transfer->resident;

        $provinces = $provinces = Territory::where('id', 'LIKE', '__')->get();
        $listOfDistricts = Territory::where('id', 'LIKE', $transfer->province . '.__')->get();
        $listOfSubDistricts = Territory::where('id', 'LIKE', $transfer->district . '.__')->get();
        $listOfVillages = Territory::where('id', 'LIKE', $transfer->sub_district . '.____')->get();

        return view('kependudukan.kepindahan.ubah', compact('transfer', 'resident', 'provinces', 'listOfDistricts', 'listOfSubDistricts', 'listOfVillages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|in:pekerjaan,pendidikan,keamanan,kesehatan,perumahan,keluarga,lainnya',
            'date_of_transfer' => 'required',
            'destination_address' => 'required',
            'province' => 'required|exists:territories,id',
            'district' => 'required|exists:territories,id',
            'sub_district' => 'required|exists:territories,id',
            'village' => 'required|exists:territories,id',
        ]);

        $province = Territory::find($request->province);
        $district = Territory::find($request->district);
        $sub_district = Territory::find($request->sub_district);
        $village = Territory::find($request->village);

        DB::transaction(function () use ($request, $id, $province, $district, $sub_district, $village) {
            $transfer = Transfer::findOrFail($id);
            $transfer->update([
                'reason' => $request->reason,
                'destination_address' => $request->destination_address,
                'date_of_transfer' => Carbon::createFromFormat('d/m/Y', $request->date_of_transfer),
                'province' => $province->id,
                'district' => $district->id,
                'sub_district' => $sub_district->id,
                'village' => $village->id,
            ]);
        });

        return redirect('/kepindahan')->with('success', 'Pengubahan data kepindahan berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $transfer = Transfer::findOrFail($id);

        $resident = $transfer->resident;
        $relation = $resident->family_member->relation;
        $familyId = $resident->family_member->family_id;

        $resident->family_member()->delete();
        $resident->death()->delete();
        $resident->birth()->delete();
        $resident->newcomer()->delete();
        $resident->beneficiary()->delete();
        $resident->poverty()->delete();
        $resident->poverty_audits()->delete();
        $resident->migration()->delete();
        $resident->land_certificates()->delete();
        $resident->lands_owned()->delete();

        // menghapus atau membuat kepala keluarga baru ketika hubungan keluarganya adalah kepala
        if ($relation == 'kepala') {
            $family = Family::find($familyId);
            $newHead = $family->members->first();

            if ($newHead) {
                $newHead = $newHead->resident;
                $newHead->family_member()->delete();
                
                $member = new FamilyMember;
                $member->relation = 'kepala';
                $member->family()->associate($family);
                $member->resident()->associate($newHead);
                $member->save();
            }
            else {
                $family->delete();
            }
        }
        
        $transfer->resident()->delete();
        $transfer->delete();

        return redirect('kepindahan')->with('success', 'Penghapusan data kepindahan berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new TransfersExport, 'data-perpindahan.xlsx');
    }
}
