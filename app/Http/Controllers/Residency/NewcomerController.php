<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Residency\Newcomer;
use App\Models\Residency\Resident;
use App\Models\Residency\Family;
use App\Models\Residency\FamilyMember;
use App\Models\Residency\Occupation;
use App\Models\Residency\Education;
use App\Models\Territory;
use App\Exports\NewcomersExport;
use Maatwebsite\Excel\Facades\Excel;

class NewcomerController extends Controller
{
    private $bloodTypeRule = 'nullable|in:a,ab,b,o,a+,b+,a-,b-,o+,o-,ab+,ab-';
    private $religionRule = 'required|in:islam,kristen,katolik,hindu,buddha,konghucu,kepercayaan';
    private $marriageStatusRule = 'required|in:kawin,belum_kawin,cerai_hidup,cerai_mati';

    public function print()
    {
        $newcomers = Newcomer::with('resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->get();

        return view('kependudukan.pendatang.cetak', compact('newcomers'));
    }

    public function index(Request $request)
    {
        $newcomers = Newcomer::with('resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa');

        if ($request->has('q')) {
            $q = $request->input('q');
            $newcomers = $newcomers->whereHas('resident', function($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('nik', 'LIKE', "%$q%");
            });
        }
        
        $newcomers = $newcomers->paginate(50);

        return view('kependudukan.pendatang.index', compact('newcomers'));
    }

    public function create()
    {
        $educations = Education::all();
        $occupations = Occupation::all();
        $provinces = Territory::where('id', 'LIKE', '__')->get();

        return view('kependudukan.pendatang.tambah', compact('educations', 'occupations', 'provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image',
            'nik' => 'required|digits:16|unique:residents,nik',
            'name' => 'required',
            'birth_place' => 'required',
            'birthday' => 'required',
            'gender' => 'required|in:male,female',
            'blood_type' => $this->bloodTypeRule,
            'nationality' => 'required|in:wni,wna,dwi',
            'religion' => $this->religionRule,
            'marriage_status' => $this->marriageStatusRule,
            'education_id' => 'required|exists:educations,id',
            'occupation_id' => 'required|exists:occupations,id',
            'no_kk' => 'required|digits:16',
            'from_address' => 'required',
            'from_province' => 'required|exists:territories,id',
            'from_district' => 'required|exists:territories,id',
            'from_sub_district' => 'required|exists:territories,id',
            'from_village' => 'required|exists:territories,id',
            'from_rt' => 'required',
            'from_rw' => 'required',
            'from_village_name' => 'required',
            'to_address' => 'required',
            'to_province' => 'required|exists:territories,id',
            'to_district' => 'required|exists:territories,id',
            'to_sub_district' => 'required|exists:territories,id',
            'to_village' => 'required|exists:territories,id',
            'to_rt' => 'required',
            'to_rw' => 'required',
            'to_village_name' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $family = Family::where('no_kk', $request->no_kk)->first();
            $resident = new Resident;
            $resident->fill([
                'nik' => $request->nik,
                'name' => $request->name,
                'birth_place' => $request->birth_place,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'blood_type' => $request->blood_type,
                'nationality' => $request->nationality,
                'religion' => $request->religion,
                'marriage_status' => $request->marriage_status,
                'resident_status' => 'pendatang',
                'education_id' => $request->education_id,
                'occupation_id' => $request->occupation_id,
            ]);

            if ($request->hasFile('photo')) {
                $photoName = $request->photo->hashName();
                $path = $request->photo->storeAs('uploaded/images', $photoName, 'public');

                $resident->photo = $path;
            }

            $resident->save();
            $familyMember = new FamilyMember;

            if (!$family) {
                $family = Family::create([
                    'no_kk' => $request->no_kk,
                    'address' => $request->to_address,
                    'province' => $request->to_province,
                    'district' => $request->to_district,
                    'sub_district' => $request->to_sub_district,
                    'village' => $request->to_village,
                    'rt' => $request->to_rt,
                    'rw' => $request->to_rw,
                    'village_name' => $request->to_village_name,
                ]);

                $familyMember->relation = 'kepala';
                
            }
            else {
                $familyMember->relation = 'lainnya';
            }
            $familyMember->family()->associate($family);
            $familyMember->resident()->associate($resident);
            $familyMember->save();

            $newcomer = Newcomer::create([
                'resident_id' => $resident->id,
                'address' => $request->from_address,
                'province' => $request->from_province,
                'district' => $request->from_district,
                'sub_district' => $request->from_sub_district,
                'village' => $request->from_village,
                'rt' => $request->from_rt,
                'rw' => $request->from_rw,
                'village_name' => $request->from_village_name,
            ]);
        });
        return redirect('/pendatang')->with('success', 'Penambahan data pendatang berhasil dilakukan!');
    }

    public function edit($id)
    {
        $newcomer = Newcomer::with('resident')
            ->where('id', $id)
            ->firstOrFail();

        $provinces = $provinces = Territory::where('id', 'LIKE', '__')->get();
        $listOfDistricts = Territory::where('id', 'LIKE', $newcomer->province . '.__')->get();
        $listOfSubDistricts = Territory::where('id', 'LIKE', $newcomer->district . '.__')->get();
        $listOfVillages = Territory::where('id', 'LIKE', $newcomer->sub_district . '.____')->get();

        return view('kependudukan.pendatang.ubah', compact('newcomer', 'provinces', 'listOfDistricts', 'listOfSubDistricts', 'listOfVillages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'province' => 'required|exists:territories,id',
            'district' => 'required|exists:territories,id',
            'sub_district' => 'required|exists:territories,id',
            'village' => 'required|exists:territories,id',
            'rt' => 'required',
            'rw' => 'required',
            'village_name' => 'required',
        ]);

        $newcomer = Newcomer::findOrFail($id);
        $newcomer->update($request->all());

        return redirect('/pendatang')->with('success', 'Pengubahan data pendatang berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $newcomer = Newcomer::findOrFail($id);

        $resident = $newcomer->resident;
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
        
        $newcomer->resident()->delete();
        $newcomer->delete();

        return redirect('/pendatang')->with('success', 'Penghapusan data pendatang berhasil dilakukan!');
    }

    public function export()
    {
        return Excel::download(new NewcomersExport, 'data-pendatang.xlsx');
    }
}
