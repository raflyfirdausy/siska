<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Residency\Birth;
use App\Models\Residency\Education;
use App\Models\Residency\Occupation;
use App\Models\Residency\Resident;
use App\Models\Residency\Family;
use App\Models\Residency\FamilyMember;
use App\Exports\BirthsExport;
use Maatwebsite\Excel\Facades\Excel;

class BirthController extends Controller
{
    public function index(Request $request) {
        $births = Birth::with('resident','family','father','mother');
        
        if ($request->has('q')) {
            $q = $request->input('q');
            $births = $births->whereHas('resident', function($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('nik', 'LIKE', "%$q%");
            });
        }
        
        $births = $births->paginate(50);

        return view('kependudukan.kelahiran.index', compact('births'));
    }

    public function create(){
        return view('kependudukan.kelahiran.tambah');
    }

    public function store(Request $request){
        $request->validate([
            'nik' => 'nullable|digits:16',
            'name' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'time_of_birth' => 'required',
            'gender' => 'required|in:male,female',
            'blood_type' => 'nullable|in:a,ab,b,o,a+,b+,a-,b-,o+,o-,ab+,ab-',
            'religion' => 'nullable|in:islam,kristen,katolik,hindu,buddha,konghucu,kepercayaan',
            'no_kk' => 'required|digits:16',
            'father_nik' => 'required|digits:16',
            'mother_nik' => 'required|digits:16',
            'child_number' => 'required|numeric',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'labor_place' => 'required|in:rumah_bersalin,lainnya',
            'labor_helper' => 'required|in:dokter,bidan,dukun,lainnya',
            'reporter' => 'required',
            'reporter_relation' => 'required|in:ayah,ibu,kakak,paman,bibi,kakek,nenek,keponakan,sepupu,kerabat',
            'first_witness' => 'required',
            'second_witness' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $resident = new Resident;
            $father = Resident::where('nik', $request->father_nik)->firstOrFail();
            $mother = Resident::where('nik', $request->mother_nik)->firstOrFail();
            $education = Education::where('name', 'Tidak/Belum Sekolah')->firstOrFail();
            $occupation = Occupation::where('name', 'Belum Bekerja')->firstOrFail();
            
            $resident->fill($request->except([
                'place_of_birth',
                'date_of_birth',
                'time_of_birth',
                'no_kk',
                'father_nik',
                'mother_nik',
                'child_number',
                'weight',
                'height',
                'labor_place',
                'labor_helper',
                'reporter',
                'reporter_relation',
                'first_witness',
                'second_witness',
            ]));
            

            $resident->birth_place = $request->place_of_birth;
            $resident->birthday = $request->date_of_birth;
            $resident->nationality = 'wni';
            $resident->resident_status = 'asli';
            $resident->marriage_status = 'belum_kawin';
            $resident->education()->associate($education);
            $resident->occupation()->associate($occupation);
            
            if (!$request->filled('nik')) {
                $resident->nik = '-';
            }
            if (!$request->has('blood_type')) {
                $resident->blood_type = '-';
            }
            if (!($request->has('religion'))) {
                $resident->religion = $father->religion;
            }

            $resident->save();

            $family = Family::where('no_kk', $request->no_kk)->firstOrFail();
            $familyMember = new FamilyMember;
            $familyMember->family()->associate($family);
            $familyMember->resident()->associate($resident);
            $familyMember->relation = 'anak';
            $familyMember->save();

            $birth = new Birth;
            $birth->fill($request->only([
                'place_of_birth',
                'date_of_birth',
                'time_of_birth',
                'child_number',
                'weight',
                'height',
                'labor_place',
                'labor_helper',
                'reporter',
                'reporter_relation',
                'first_witness',
                'second_witness',
            ]));
            
            $birth->father()->associate($father);
            $birth->mother()->associate($mother);
            $birth->family()->associate($family);
            $birth->resident()->associate($resident);
            $birth->save();
        });
        
        return redirect("kelahiran")->with('success', 'Penambahan data kelahiran berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $birth = Birth::findOrFail($id);
        $birth->resident()->delete();
        $familyMember = $birth->familyMember;
        $familyMember->delete();
        $birth->delete();

        return redirect("kelahiran")->with('success', 'Penghapusan data kelahiran berhasil dilakukan!');
    }

    public function edit(Request $request, $id){
        $birth = Birth::with('resident','family','father','mother')->where('id', $id)->first();

        return view('kependudukan.kelahiran.ubah', compact('birth'));
    }

    public function update(Request $request, $id){
        $birth = Birth::findOrFail($id);
        $resident = $birth->resident;

        $birth->fill($request->only([
            'place_of_birth',
            'date_of_birth',
            'time_of_birth',
            'child_number',
            'weight',
            'height',
            'labor_place',
            'labor_helper',
            'reporter',
            'reporter_relation',
            'first_witness',
            'second_witness',
        ]));

        $resident->fill($request->except([
            'place_of_birth',
            'date_of_birth',
            'time_of_birth',
            'no_kk',
            'father_nik',
            'mother_nik',
            'child_number',
            'weight',
            'height',
            'labor_place',
            'labor_helper',
            'reporter',
            'reporter_relation',
            'first_witness',
            'second_witness',
        ]));

        $resident->birth_place = $request->place_of_birth;
        $resident->birthday = $request->date_of_birth;
        
        if (!$request->filled('nik')) {
            $resident->nik = '-';
        }
        if (!$request->has('blood_type')) {
            $resident->blood_type = '-';
        }
        if (!($request->has('religion'))) {
            $resident->religion = $father->religion;
        }

        $resident->save();

        $father = Resident::where('nik', $request->father_nik)->firstOrFail();
        $mother = Resident::where('nik', $request->mother_nik)->firstOrFail();
        $oldFamily = $birth->family;
        $oldFamilyMember = $birth->familyMember;
        $family = Family::where('no_kk', $request->no_kk)->firstOrFail();
        
        // ubah keluarga dan hubungan keluarga kalau nomor kk baru tidak sama dengan nomor kk lama
        if ($oldFamily->id != $family->id) {
            $oldFamilyMember->delete();
            $familyMember = new FamilyMember;
            $familyMember->family()->associate($family);
            $familyMember->resident()->associate($resident);
            $familyMember->relation = 'anak';
            $familyMember->save();

            $resident->family_member()->associate($familyMember);
            $resident->save();
        }
        $birth->father()->associate($father);
        $birth->mother()->associate($mother);
        $birth->family()->associate($family);

        $birth->save();
        
        return redirect("kelahiran")->with('success', 'Pengubahan data kelahiran berhasil dilakukan!');
    }

    public function print()
    {
        $births = Birth::with('resident','family','father','mother')->get();
        return view('kependudukan.kelahiran.cetak', compact('births') );
    }

    public function export()
    {
        return Excel::download(new BirthsExport, 'data-kelahiran.xlsx');
    }
}
