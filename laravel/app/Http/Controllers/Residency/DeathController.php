<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Residency\Resident;
use App\Models\Residency\Death;
use App\Exports\DeathsExport;
use Maatwebsite\Excel\Facades\Excel;

class DeathController extends Controller
{
    public function index(Request $request){
        $deaths = Death::with('resident');

        if ($request->has('q')) {
            $q = $request->input('q');
            $deaths = $deaths->whereHas('resident', function($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('nik', 'LIKE', "%$q%");
            });
        }
        
        $deaths = $deaths->paginate(50);

        return view('kependudukan.kematian.index', compact('deaths'));
    }

    public function create(){
        return view('kependudukan.kematian.tambah');
    }

    public function store(Request $request){
        $request->validate([
            'nik' => 'required|digits:16|exists:residents,nik',
            'date_of_death' => 'required',
            'time_of_death' => 'required',
            'place_of_death' => 'required|in:rumah_sakit,lainnya',
            'cause_of_death' => 'required',
            'determinant' => 'required|in:dokter,perawat,tenaga_kesehatan,lainnya',
            'reporter' => 'required',
            'reporter_relation' => 'required|in:ayah,ibu,kakak,paman,bibi,kakek,nenek,keponakan,sepupu,kerabat',
        ]);

        DB::transaction(function () use ($request) {
            $resident = Resident::where('nik', $request->nik)->canBeDisplayed()->firstOrFail();
            Death::create([
                'resident_id' => $resident->id,
                'date_of_death' => $request->date_of_death,
                'time_of_death' => $request->time_of_death,
                'place_of_death' => $request->place_of_death,
                'cause_of_death' => $request->cause_of_death,
                'determinant' => $request->determinant,
                'reporter' => $request->reporter,
                'reporter_relation' => $request->reporter_relation,
            ]);
        });

        return redirect("/kematian")->with('success','Penambahan data kematian berhasil dilakukan!');
    }
    public function destroy($id)
    {
        $death = Death::findOrFail($id);

        $resident = $death->resident;
        $relation = $resident->family_member->relation;
        $familyId = $resident->family_member->family_id;

        $resident->family_member()->delete();
        $resident->birth()->delete();
        $resident->transfer()->delete();
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

        $death->resident()->delete();
        $death->delete();
        
        return redirect("/kematian")->with('success','Penghapusan data kematian berhasil dilakukan!');
    }

    public function edit($id){
        $death = Death::where('id', $id)->firstOrFail();
        return view('kependudukan.kematian.ubah', compact('death'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'date_of_death' => 'required',
            'time_of_death' => 'required',
            'place_of_death' => 'required|in:rumah_sakit,lainnya',
            'cause_of_death' => 'required',
            'determinant' => 'required|in:dokter,perawat,tenaga_kesehatan,lainnya',
            'reporter' => 'required',
            'reporter_relation' => 'required|in:ayah,ibu,kakak,paman,bibi,kakek,nenek,keponakan,sepupu,kerabat',
        ]);
        
        $death = Death::findOrFail($id);
        $death->update([
            'date_of_death' => $request->date_of_death,
            'time_of_death' => $request->time_of_death,
            'place_of_death' => $request->place_of_death,
            'cause_of_death' => $request->cause_of_death,
            'determinant' => $request->determinant,
            'reporter' => $request->reporter,
            'reporter_relation' => $request->reporter_relation
        ]);
        
        return redirect("/kematian")->with('success','Pengubahan data kematian berhasil dilakukan!');
    }

    public function print()
    {
        $kematian = Death::with('resident')->get();
        return view('kependudukan.kematian.cetak', compact('kematian'));
    }

    public function export()
    {
        return Excel::download(new DeathsExport, 'data-kematian.xlsx');
    }
}
