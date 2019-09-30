<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Residency\Family;
use App\Models\Residency\FamilyMember;
use App\Models\Residency\Occupation;
use App\Models\Residency\Education;
use App\Models\Territory;
use App\Exports\FamiliesExport;
use Maatwebsite\Excel\Facades\Excel;

class FamilyController extends Controller
{
    private $bloodTypeRule = 'nullable|in:a,ab,b,o,a+,b+,a-,b-,o+,o-,ab+,ab-';
    private $religionRule = 'required|in:islam,kristen,katolik,hindu,buddha,konghucu,kepercayaan';
    private $marriageStatusRule = 'required|in:kawin,belum_kawin,cerai_hidup,cerai_mati';

    public function print()
    {
        $families = Family::with('members', 'members.resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->get();
        return view('kependudukan.keluarga.cetak', compact('families'));
    }

    public function index(Request $request)
    {
        $families = Family::with('members', 'members.resident', 'provinsi', 'kabupaten', 'kecamatan', 'desa');
        if ($request->has('q')) {
            $q = $request->input('q');
            
            $families = $families->where('no_kk', 'LIKE', '%'.$q.'%')
                ->orWhereHas('members', function($query) use ($q) {
                    return $query->whereHas('resident', function($query) use ($q) {
                        return $query->where('name', 'LIKE', '%'.$q.'%');
                    });
                })
                ->paginate(50);
        }
        else {
            $families = $families->paginate(50);
        }

        return view('kependudukan.keluarga.index', compact('families'));
    }

    public function create()
    {
        $educations = Education::all();
        $occupations = Occupation::oldest('name')->get();
        $provinces = Territory::where('id', 'LIKE', '__')->get();

        return view('kependudukan.keluarga.tambah', compact('educations', 'occupations', 'provinces'));
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
            'resident_status' => 'required|in:asli,pendatang,pindah,sementara',
            'education_id' => 'required|exists:educations,id',
            'occupation_id' => 'required|exists:occupations,id',
            'no_kk' => 'required|digits:16|unique:families,no_kk',
            'address' => 'required',
            'province' => 'required|exists:territories,id',
            'district' => 'required|exists:territories,id',
            'sub_district' => 'required|exists:territories,id',
            'village' => 'required|exists:territories,id',
            'rt' => 'required',
            'rw' => 'required',
            'village_name' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $family = Family::create($request->only('no_kk', 'address', 'province', 'district', 'sub_district', 'village', 'rt', 'rw', 'village_name'));

            $familyHead = new Resident;
            $familyHead->fill($request->except('photo', 'no_kk', 'address', 'province', 'district', 'sub_district', 'village', 'rt', 'rw', 'village_name'));
            if ($request->hasFile('photo')) {
                $photoName = $request->photo->hashName();
                $path = $request->photo->storeAs('uploaded/images', $photoName, 'public');

                $familyHead->photo = $path;
            }

            $familyHead->save();

            // Menambahkan kepala keluarga ke dalam keluarga yang sudah ditambahkan
            $familyMember = new FamilyMember;
            $familyMember->relation = 'kepala';
            $familyMember->family()->associate($family);
            $familyMember->resident()->associate($familyHead);
            $familyMember->save();
        });

        return redirect("/keluarga/$request->no_kk/tambah-anggota")->with('success', 'Penambahan keluarga berhasil dilakukan! Silahkan menambahkan anggota keluarga lagi.');
    }

    public function createMember($no_kk)
    {
        $family = Family::with(['members', 'members.resident'])
            ->where('no_kk', $no_kk)
            ->firstOrFail();

            $educations = Education::all();
            $occupations = Occupation::oldest('name')->get();

        return view('kependudukan.keluarga.tambah-anggota', compact('family', 'educations', 'occupations'));
    }

    public function storeMember(Request $request, $no_kk)
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
            'resident_status' => 'required|in:asli,pendatang,pindah,sementara',
            'education_id' => 'required|exists:educations,id',
            'occupation_id' => 'required|exists:occupations,id',
            'relation' => 'required|in:kepala,suami,istri,anak,menantu,cucu,orang_tua,mertua,famili_lain,pembantu,lainnya',
        ]);
        
        $family = Family::where('no_kk', $no_kk)->firstOrFail();

        DB::transaction(function () use ($family, $request) {
            $member = new Resident;
            $member->fill($request->except('photo', 'relation'));
            if ($request->hasFile('photo')) {
                $photoName = $request->photo->hashName();
                $path = $request->photo->storeAs('uploaded/images', $photoName, 'public');

                $member->photo = $path;
            }

            $member->save();

            $familyMember = new FamilyMember;
            $familyMember->relation = $request->relation;
            $familyMember->family()->associate($family);
            $familyMember->resident()->associate($member);
            $familyMember->save();
        });

        return redirect("/keluarga/$no_kk")->with('success', 'Penambahan anggota keluarga berhasil dilakukan!');
    }

    public function show($no_kk)
    {
        $family = Family::with(['members', 'members.resident'])
            ->where('no_kk', $no_kk)
            ->firstOrFail();

        return view('kependudukan.keluarga.lihat', compact('family'));
    }

    public function edit($no_kk)
    {
        $family = Family::with(['members', 'members.resident'])
            ->where('no_kk', $no_kk)
            ->firstOrFail();
        $provinces = Territory::where('id', 'LIKE', '__')->get();
        $listOfDistricts = Territory::where('id', 'LIKE', $family->province . '.__')->get();
        $listOfSubDistricts = Territory::where('id', 'LIKE', $family->district . '.__')->get();
        $listOfVillages = Territory::where('id', 'LIKE', $family->sub_district . '.____')->get();

        return view('kependudukan.keluarga.ubah', compact('family', 'provinces', 'listOfDistricts', 'listOfSubDistricts', 'listOfVillages'));
    }

    public function update(Request $request, $no_kk)
    {
        $request->validate([
            'no_kk' => 'required|digits:16',
            'address' => 'required',
            'province' => 'required|exists:territories,id',
            'district' => 'required|exists:territories,id',
            'sub_district' => 'required|exists:territories,id',
            'village' => 'required|exists:territories,id',
            'rt' => 'required',
            'rw' => 'required',
            'village_name' => 'required',
        ]);

        $family = Family::with(['members', 'members.resident'])
            ->where('no_kk', $no_kk)
            ->first();

        DB::transaction(function () use ($family, $request) {
            $family->fill($request->all());

            $family->save();
        });

        return redirect("/keluarga/$family->no_kk")->with('success', 'Pengubahan data keluarga berhasil dilakukan!');
    }

    public function destroy($no_kk)
    {
        $family = Family::with(['members', 'members.resident'])
            ->where('no_kk', $no_kk)
            ->firstOrFail();
        
        DB::transaction(function () use ($family) {
            foreach ($family->members as $m) {
                $m->resident->transfer()->delete();
                $m->resident->birth()->delete();
                $m->resident->death()->delete();
                $m->resident->newcomer()->delete();
                $m->resident->beneficiary()->delete();
                $m->resident->poverty()->delete();
                $m->resident->poverty_audits()->delete();
                $m->resident->migration()->delete();
                $m->resident->land_certificates()->delete();
                $m->resident->lands_owned()->delete();
                $m->resident()->delete();
            }

            $family->members()->delete();

            $family->delete();
        });

        return redirect('/keluarga')->with('success', 'Penghapusan data keluarga berhasil dilakukan!');
    }

    public function getFamily($q)
    {
        $families = Family::with(['members', 'members.resident'])
            ->where('no_kk', 'LIKE', '%'.$q.'%')
            ->orWhereHas('members', function($query) use ($q) {
                return $query->whereHas('resident', function($query) use ($q) {
                    return $query->where('name', 'LIKE', '%'.$q.'%');
                });
            })
            ->get();
        $families = $families->map(function($value) {
            $val = $value->members->filter(function($value) {
                return $value->relation == 'kepala';
            })[0];
            if ($val->count() < 1) {
                $val = $value->members->first();
            }
            return collect([
                'no_kk' => $value->no_kk,
                'head' => $val->resident,
            ]);
        });
        return $families;
    }

    public function getFamilyMembers($no_kk)
    {
        $family = Family::with(['members', 'members.resident'])
            ->where('no_kk', $no_kk)
            ->first();

        if (!$family) {
            return collect([]);
        }

        $familyMembers = $family->members->filter(function($val) {
            return $val->resident()->canBeDisplayed()->first();
        })
        ->map(function($item) {
            return collect([
                'resident_id' => $item->resident_id,
                'nik' => $item->resident->nik,
                'name' => $item->resident->name,
                'relation' => $item->relation,
            ]);
        });

        return $familyMembers;
    }

    public function export()
    {
        return Excel::download(new FamiliesExport, 'data-keluarga.xlsx');
    }
}
