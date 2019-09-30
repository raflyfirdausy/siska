<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Residency\Occupation;
use App\Models\Residency\Education;
use App\Models\Residency\Family;
use App\Models\Residency\FamilyMember;
use App\Helpers\TemplateReplacer;
use App\Models\Territory;
use App\Models\General\Official;
use App\Exports\ResidentsExport;
use App\Exports\DPTExport;
use Maatwebsite\Excel\Facades\Excel;

class ResidentController extends Controller
{
    private $bloodTypeRule = 'nullable|in:a,ab,b,o,a+,b+,a-,b-,o+,o-,ab+,ab-';
    private $religionRule = 'required|in:islam,kristen,katolik,hindu,buddha,konghucu,kepercayaan';
    private $marriageStatusRule = 'required|in:kawin,belum_kawin,cerai_hidup,cerai_mati';

    private function applySearch($query, $request)
    {
        $age = $request->umur ?? false;
        $gender = $request->jenis_kelamin ?? false;
        $bloodType = $request->golongan_darah ?? false;
        $nationality = $request->kewarganegaraan ?? false;
        $religion = $request->agama ?? false;
        $marriageStatus = $request->status_perkawinan ?? false;
        $residentStatus = $request->status_kependudukan ?? false;
        $occupation = $request->pekerjaan ?? false;
        $education = $request->pendidikan ?? false;

        $query = $query->when($age, function ($q) use ($age) {
            $age = Carbon::today()->subYears(intval($age));
            return $q->where('birthday', '<=', $age);
        })
            ->when($gender, function ($q) use ($gender) {
                $gender = $gender == 'pria' ? 'male' : 'female';
                return $q->where('gender', $gender);
            })
            ->when($bloodType, function ($q) use ($bloodType) {
                return $q->where('blood_type', $bloodType);
            })
            ->when($nationality, function ($q) use ($nationality) {
                return $q->where('nationality', $nationality);
            })
            ->when($religion, function ($q) use ($religion) {
                return $q->where('religion', $religion);
            })
            ->when($marriageStatus, function ($q) use ($marriageStatus) {
                return $q->where('marriage_status', $marriageStatus);
            })
            ->when($residentStatus, function ($q) use ($residentStatus) {
                return $q->where('resident_status', $residentStatus);
            })
            ->when($education, function ($q) use ($education) {
                return $q->where('education_id', $education);
            })
            ->when($occupation, function ($q) use ($occupation) {
                return $q->where('occupation_id', $occupation);
            });

        return $query;
    }

    public function index(Request $request)
    {
        $residents = Resident::canBeDisplayed();

        if ($request->has('q')) {
            $q = $request->input('q');
            $residents = $residents->where('nik', 'LIKE', '%' . $q . '%')
                ->orWhere('name', 'LIKE', '%' . $q . '%');
        } elseif ($request->has('detail')) {
            $request->validate([
                'umur' => 'nullable|numeric',
                'gender' => 'nullable|in:pria,wanita',
                'golongan_darah' => 'nullable|in:a,ab,b,o,a+,b+,a-,b-,o+,o-,ab+,ab-',
                'kewarganegaraan' => 'nullable|in:wni,wna,dwi',
                'agama' => 'nullable|in:islam,kristen,katolik,hindu,buddha,konghucu,kepercayaan',
                'status_perkawinan' => 'nullable|in:kawin,belum_kawin,cerai_hidup,cerai_mati',
                'status_kependudukan' => 'nullable|in:asli,pendatang,pindah,sementara',
                'pendidikan' => 'nullable|exists:educations,id',
                'pekerjaan' => 'nullable|exists:occupations,id',
            ]);

            $residents = $this->applySearch($residents, $request);
        }
        $educations = Education::all();
        $occupations = Occupation::all();

        $residents = $residents->paginate(50);

        return view('kependudukan.penduduk.index', compact('residents', 'educations', 'occupations'));
    }

    public function print()
    {
        $residents = Resident::with('occupation', 'education')->get();
        return view('kependudukan.penduduk.cetak', compact('residents'));
    }

    public function show($nik)
    {
        $officials = Official::all();
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();

        $provinces = $provinces = Territory::where('id', 'LIKE', '__')->get();

        return view('kependudukan.penduduk.lihat', compact('resident', 'provinces', 'officials'));
    }

    public function edit($nik)
    {
        $resident = Resident::where('nik', $nik)->firstOrFail();
        $educations = Education::all();
        $occupations = Occupation::oldest('name')->get();

        return view('kependudukan.penduduk.ubah', compact('resident', 'educations', 'occupations'));
    }

    public function update(Request $request, $nik)
    {
        $request->validate([
            'photo' => 'nullable|image',
            'nik' => 'required|digits:16',
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

        $resident = Resident::where('nik', $nik)->firstOrFail();

        DB::transaction(function () use ($request, $resident) {
            $resident->fill($request->except('photo', 'relation'));

            if ($request->hasFile('photo')) {
                $photoName = $request->photo->hashName();
                $path = $request->photo->storeAs('uploaded/images', $photoName, 'public');

                $resident->photo = $path;
            }

            $resident->family_member()->update([
                'relation' => $request->relation,
            ]);

            $resident->save();
        });

        return redirect("/penduduk/$resident->nik")->with('success', 'Pengubahan data penduduk berhasil dilakukan!');
    }

    public function destroy($nik)
    {
        $resident = Resident::where('nik', $nik)->firstOrFail();

        $relation = $resident->family_member->relation;
        $familyId = $resident->family_member->family_id;

        $resident->family_member()->delete();

        $resident->delete();

        $resident->transfer()->delete();
        $resident->birth()->delete();
        $resident->death()->delete();
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
            } else {
                $family->delete();
            }
        }

        return redirect('/penduduk')->with('success', 'Penghapusan data penduduk berhasil dilakukan!');
    }







    //START ================================================================================================

    public function print_keterangan_pengantar(Request $request, $nik)
    {
        // die("haha");
        $pamong = Official::find($request->pamong_id);
        

        if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
            $linkRequest = public_path("json/$nik.json");
        } else {
            // $linkRequest = public_path("json/tidak_ditemukan.json");
            return redirect('/modul-kependudukan');
        }
        // $data = json_decode(file_get_contents($linkRequest . $nik));
        
        // die(json_encode($alamatDesaLengkap));

        // $resident = Resident::with(['family_member', 'family_member.family'])
        //     ->where('nik', $nik)->firstOrFail();
        // $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        // $head = $family->familyHead();
        // $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        // $birthday = $resident->birthday;
        $data = json_decode(file_get_contents($linkRequest));
        $alamatDesaLengkap = option()->office_address . ", Desa " . option()->desa->name . " Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $desa = option()->desa->name;
        $file = 'a_surat_pengantar.rtf';
        $replace = [
            'judul_kabupaten' => substr(option()->kabupaten->name, 5),
            'judul_kecamatan' => strtoupper(option()->kecamatan->name),
            'judul_desa' => strtoupper(option()->desa->name),
            'alamatdesa' => $alamatDesaLengkap,
            'nomor_surat' => $request->no_surat,
            'jabatan' => $pamong->jabatan,
            'desa' => option()->desa->name,
            'kecamatan' => option()->kecamatan->name, 
            'kabupaten' => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi' => ucwords(strtolower(option()->provinsi->name)),
            'nik' => $data->content[0]->NIK,
            'nama' => $data->content[0]->NAMA_LGKP,
            'tempat_lahir' => $data->content[0]->TMPT_LHR,
            'tanggal_lahir' => Carbon::createFromFormat('Y-m-d', $data->content[0]->TGL_LHR)->format('d M Y'),
            'warga_negara' => "INDONESIA",
            'agama' => $data->content[0]->AGAMA,
            'jenis_kelamin' => $data->content[0]->JENIS_KLMIN,
            'pekerjaan' => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal' => ucwords(strtolower($data->content[0]->ALAMAT)),
            'alamat_desa_tinggal' => option()->desa->name,
            'golongan_darah' => $data->content[0]->GOL_DARAH == "TIDAK TAHU" ? "-" : $data->content[0]->GOL_DARAH,
            'keperluan' => $request->keperluan,
            'mulai_berlaku' => Carbon::createFromFormat('Y-m-d', $request->mulai_berlaku)->format('d M Y'),
            'tgl_akhir' => Carbon::createFromFormat('Y-m-d', $request->tgl_akhir)->format('d M Y'),
            'tanggal_indo' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->format('d M Y'),
            'pamong' => $pamong->name,
            'nip' => $pamong->nip,
        ];
        $filename = 'a_surat_pengantar.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    public function modulKependudukanDetail($nik)
    {
        // $linkRequest = "http://localhost/tes/request.php?nik=";
        // $linkRequest = "http://10.33.4.24:8081/ws_server/get_json/tlagawera/carinik?USER_ID=TLAGAWERA&PASSWORD=12345&NIK=";
        //3304061303090001
        if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
            $linkRequest = public_path("json/$nik.json");
        } else {
            // $linkRequest = public_path("json/tidak_ditemukan.json");
            return redirect('/modul-kependudukan');
        }


        // $data = json_decode(file_get_contents($linkRequest . $nik));
        $data = json_decode(file_get_contents($linkRequest));
        // die(json_encode($data));

        $officials = Official::all();

        return view('kependudukan.penduduk.modul-kependudukan-lihat', compact('data', 'officials'));
    }

    public function modulKependudukan(Request $request)
    {
        // $linkRequest = "http://localhost/tes/request.php?nik=";
        // $linkRequest = "http://10.33.4.24:8081/ws_server/get_json/tlagawera/carinik?USER_ID=TLAGAWERA&PASSWORD=12345&NIK=";
        $linkRequest = public_path("json/tidak_ditemukan.json");
        if ($request->has('nik')) {
            $nik = $request->input('nik');
            if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
                $linkRequest = public_path("json/$nik.json");
            } else {
                $linkRequest = public_path("json/tidak_ditemukan.json");
            }
            // $data = json_decode(file_get_contents($linkRequest . $nik));
            $data = json_decode(file_get_contents($linkRequest));
            if (!isset($data->content->RESPON)) {
                $bday = new \DateTime($data->content[0]->TGL_LHR); // Your date of birth
                $today = new \Datetime(date('Y-m-d'));
                $diff = $today->diff($bday);

                $data->content[0]->AGE = $diff->y;
            }
        } else {
            $data = json_decode(file_get_contents($linkRequest));
        }
        $data->status = !isset($data->content->RESPON) ? 200 : 404;
        //die(json_encode($data));
        // die(public_path());
        return view('kependudukan.penduduk.modul-kependudukan', compact('data'));
    }

    //END ================================================================================================










    public function dpt(Request $request)
    {
        $ageLegalVote = Carbon::today()->subYears(17);
        $residents = Resident::where('birthday', '<=', $ageLegalVote);

        if ($request->has('q')) {
            $q = $request->input('q');
            $residents = $residents->where('nik', 'LIKE', '%' . $q . '%')
                ->orWhere('name', 'LIKE', '%' . $q . '%');
        }

        $residents = $residents
            ->canBeDisplayed()
            ->get();

        return view('kependudukan.penduduk.dpt', compact('residents'));
    }

    public function printDpt()
    {
        $ageLegalVote = Carbon::today()->subYears(17);
        $residents = Resident::where('birthday', '<=', $ageLegalVote)
            ->canBeDisplayed()
            ->get();

        return view('kependudukan.penduduk.cetak-dpt', compact('residents'));
    }

    public function getResident(Request $request, $nik)
    {
        $result = Resident::where('nik', 'LIKE', '%' . $nik . '%')->canBeDisplayed();
        $no_kk = $request->query('no_kk', false);
        $notBeneficiary = $request->query('not_beneficiary', false);
        $male = $request->query('pria', false);
        $female = $request->query('wanita', false);

        if ($no_kk) {
            $result = $result->whereHas('family_member', function ($q) use ($no_kk) {
                return $q->wherehas('family', function ($q) use ($no_kk) {
                    return $q->where('no_kk', $no_kk);
                });
            });
        }
        if ($notBeneficiary) {
            $result = $result->isNotBeneficiary();
        }
        if ($male) {
            $result = $result->where('gender', 'male');
        }
        if ($female) {
            $result = $result->where('gender', 'female');
        }

        return $result->get();
    }

    public function getIbu(Request $request, $nik)
    {
        $result = Resident::where('nik', 'LIKE', '%' . $nik . '%')->canBeDisplayed();

        $no_kk = $request->query('no_kk', false);
        $notBeneficiary = $request->query('not_beneficiary', false);

        if ($no_kk) {
            $result = $result->whereHas('family_member', function ($q) use ($no_kk) {
                return $q->wherehas('family', function ($q) use ($no_kk) {
                    return $q->where('no_kk', $no_kk);
                });
            });
        }
        if ($notBeneficiary) {
            $result = $result->isNotBeneficiary();
        }

        return $result->get();
    }

    public function statistics()
    {
        $educations = $this->getEducationStatistics();
        $occupations = $this->getOccupationStatistics();
        $bloodTypes = $this->getBloodTypeStatistics();
        $marriages = $this->getMarriageStatistics();
        $religions = $this->getReligionStatistics();
        $genders = $this->getGenderStatistics();

        return view('kependudukan.penduduk.statistik', compact(
            'educations',
            'occupations',
            'bloodTypes',
            'marriages',
            'religions',
            'genders'
        ));
    }

    public function getEducationStatistics()
    {
        $educations = [];

        $eds = Education::with('residents')->get();

        foreach ($eds as $ed) {
            $educations[] = [
                'label' => $ed->name,
                'value' => $ed->residents->count() ?: 0,
            ];
        }


        return $educations;
    }

    public function getOccupationStatistics()
    {
        $occupations = [];

        $occs = Occupation::with('residents')->get();

        foreach ($occs as $o) {
            $occupations[] = [
                'label' => $o->name,
                'value' => $o->residents->count() ?: 0,
            ];
        }


        return collect($occupations);
    }

    public function getBloodTypeStatistics()
    {
        $bloodType = collect([
            'a', 'ab', 'b', 'o',
            'a+', 'b+', 'a-', 'b-',
            'o+', 'o-', 'ab+', 'ab-',
        ]);

        return $bloodType->map(function ($item) {
            $count = Resident::where('blood_type', $item)->count();
            return collect([
                'label' => strtoupper($item),
                'value' => $count,
            ]);
        });
    }

    public function getMarriageStatistics()
    {
        $marriages = collect([
            'kawin', 'belum_kawin', 'cerai_hidup', 'cerai_mati',
        ]);

        return $marriages->map(function ($item) {
            $count = Resident::where('marriage_status', $item)->count();
            $item = explode('_', $item);
            for ($i = 0; $i < count($item); $i++) {
                $item[$i] = ucfirst($item[$i]);
            }
            $item = implode(' ', $item);
            return collect([
                'label' => $item,
                'value' => $count,
            ]);
        });
    }

    public function getReligionStatistics()
    {
        $religions = collect([
            'islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu',
        ]);

        return $religions->map(function ($item) {
            $count = Resident::where('religion', $item)->count();
            return collect([
                'label' => ucfirst($item),
                'value' => $count,
            ]);
        });
    }

    public function getGenderStatistics()
    {
        $genders = collect([
            'male', 'female',
        ]);

        return $genders->map(function ($item) {
            $count = Resident::where('gender', $item)->count();
            return collect([
                'label' => $item == 'male' ? 'Lelaki' : 'Perempuan',
                'value' => $count,
            ]);
        });
    }

    public function export()
    {
        return Excel::download(new ResidentsExport, 'data-penduduk.xlsx');
    }

    public function exportDpt()
    {
        return Excel::download(new DPTExport, 'daftar-pemilik-tetap.xlsx');
    }

    // done 2
    public function printbiopddk(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = new Resident;
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();

        $file = 'surat_bio_penduduk.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'umur' => $resident->birthday->age,
            'judul_surat' => 'Surat Biodata Penduduk',
            'nomor_surat' => $_GET['no_surat'],
            'no_surat' => $_GET['no_surat2'],
            'nmr_surat' => $_GET['no_surat3'],
            'tahun' => date('Y'),
            'tayo' => $resident->name,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'sex' => $resident->jenkel,
            'status' => $resident->status_kawin,
            'pekerjaan' => $resident->occupation->name,
            'pendidikan' => $resident->education->name,
            'hubungan' => $resident->family_member->hubungan,
            'alamat' => $resident->family_member->family->alamat,
            'no_ktp' => $nik,
            'no_kk' => $resident->family_member->family['no_kk'],
            'darah' => $resident->goldar,
            'jabatan' => $pamong->jabatan,
            'almtsebelum' => $_GET['almtsebelum'],
            'end_paspor' => $request->filled('end_paspor') ? Carbon::createFromFormat('Y-m-d', $_GET['end_paspor'])->format('d M Y') : '-',
            'paspor' => $request->filled('no_paspor') ? $_GET['no_paspor'] : '-',
            'no_akta_kel' => $_GET['no_akta_lahir'],
            'no_akta_kawin' => $request->filled('no_akta_kawin') ? $_GET['no_akta_kawin'] : '-',
            'tgl_akta_kawin' => $request->filled('tgl_akta_kawin') ? Carbon::createFromFormat('Y-m-d', $_GET['tgl_akta_kawin'])->format('d M Y') : '-',
            'no_akta_cerai' => $request->filled('no_akta_cerai') ? $_GET['no_akta_cerai'] : '-',
            'tgl_cerai' => $request->filled('tgl_cerai') ? Carbon::createFromFormat('Y-m-d', $_GET['tgl_cerai'])->format('d M Y') : '-',
            'cacat' => $_GET['cacat'],
            'kepala_kk' => $head->name,
            'n1k' => $_GET['n1k'],
            'b4pac' => $_GET['b4pac'],
            'n1c' => $_GET['n1c'],
            'ib0' => $_GET['ib0'],
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
            'tglsurat' => date('d M Y'),
        ];

        $filename = 'surat_bio_penduduk.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printKetPngtr(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $birthday = $resident->birthday;
        $file = 'surat_ket_pengantar.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'almtds' => option()->office_address,
            'umur' => $resident->birthday->age,
            'judul_surat' => 'Surat Keterangan Pengantar',
            'nomor_surat' => $_GET['no_surat'],
            'tglsurat' => date('d M Y'),
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'sex' => $resident->jenkel,
            'pekerjaan' => $resident->occupation->name,
            'alamat' => $resident->family_member->family->alamat,
            'no_ktp' => $nik,
            'no_kk' => $resident->family_member->family['no_kk'],
            'keperluan' => $_GET['keperluan'],
            'darah' => $resident->goldar,
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
            'mulai_berlaku' => Carbon::createFromFormat('Y-m-d', $request->mulai_berlaku)->format('d M Y'),
            'tgl_akhir' => Carbon::createFromFormat('Y-m-d', $request->tgl_akhir)->format('d M Y'),
        ];
        $filename = 'surat_ket_pengantar.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printKetDomisili(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_domisili.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'almtds' => option()->office_address,
            'tgl_surat' => date('d M Y'),
            'judul_surat' => 'Surat Keterangan Domisili',
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'agama' => $resident->agama,
            'status' => $resident->status_kependudukan,
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'nationality' => $resident->kewarganegaraan,
            'erte' => $family->rt,
            "b{$family->rt}mpat" => 'bertempat',
            'erwe' => $family->rw,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->name,
            'keperluan' => $_GET['keperluan'],
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
            'almtjln' => $family->address,
        ];
        $filename = 'surat_ket_domisili.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    //done 2
    public function printSKCK(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_catatan_kriminal.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'judul_surat' => 'Surat Keterangan Catatan Kepolisian',
            'tglsurat' => date('d M Y'),
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'agama' => $resident->agama,
            'status' => $resident->status_kependudukan,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->name,
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'nationality' => $resident->kewarganegaraan,
            'keperluan' => $_GET['keperluan'],
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'SKCK.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printSKTM(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_kurang_mampu.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            "{$resident->name}nya" => 'namanya',
            'no_ktp' => $nik,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'erte' => $family->rt,
            'erwe' => $family->rw,
            'pekerjaan' => $resident->occupation->name,
            'keplrn' => $_GET['keperluan'],
            'tanggalsurat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'SKTM.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printKehilangan(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_Kehilangan.rtf';
        $replace = [
            'alamat' => $family->address,
            'almtds' => option()->office_address,
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->name,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'erte' => $family->rt,
            'erwe' => $family->rw,
            'pendidikan' => $resident->education->name,
            'status' => $resident->status_kependudukan,
            'pekerjaan' => $resident->occupation->name,
            'barang' => $_GET['barang'],
            'rincian' => $_GET['rincian'],
            'ktrngn' => $_GET['keterangan'],
            'tanggalsurat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'alamat_des' => option()->office_address,
            'provinsi' => option()->provinsi->name,
            'des' => $resident->family->desa->name,
            'kec' => $resident->family->kecamatan->name,
            'kab' => $resident->family->kabupaten->name,

        ];
        $filename = 'Surat Kehilangan.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printKeramaian(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_izin_keramaian.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'alamat' => $family->address,
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->name,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'pendidikan' => $resident->education->name,
            'status' => $resident->status_kependudukan,
            'pekerjaan' => $resident->occupation->name,
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'erte' => $family->rt,
            'erwe' => $family->rw,
            'jenis_keramaian' => $_GET['keramaian'],
            'dari' => Carbon::createFromFormat('Y-m-d', $_GET['dari'])->format('d M Y'),
            'selesai' => Carbon::createFromFormat('Y-m-d', $_GET['sampai'])->format('d M Y'),
            'kprln' => $_GET['keterangan'],
            'tanggalsurat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'Surat Izin Keramaian.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printUsaha(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_usaha.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->name,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'alamat' => $resident->family_member->family['address'],
            'status' => $resident->status_kependudukan,
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'form_usaha' => $_GET['usaha'],
            'dari' => Carbon::createFromFormat('Y-m-d', $_GET['dari'])->format('d M Y'),
            'selesai' => Carbon::createFromFormat('Y-m-d', $_GET['sampai'])->format('d M Y'),
            'ketrngn' => $_GET['keterangan'],
            'tanggalsurat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'Surat Keterangan Usaha.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printketPddk(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_penduduk.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'sebutan_desa' => 'DESA',
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'almtds' => option()->office_address,
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->name,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'umur' => $resident->birthday->age,
            'sex' => $resident->jenkel,
            'alamat' => $resident->family_member->family['address'],
            'status' => $resident->status_kependudukan,
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'dari' => Carbon::createFromFormat('Y-m-d', $_GET['dari'])->format('d M Y'),
            'selesai' => Carbon::createFromFormat('Y-m-d', $_GET['sampai'])->format('d M Y'),
            'ketrngn' => $_GET['keterangan'],
            'tanggalsurat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'Surat Keterangan Penduduk.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printKtpProses(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_ket_ktp_dalam_proses.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'sebutan_desa' => 'DESA',
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'almtds' => option()->office_address,
            'nomor_surat' => $_GET['no_surat'],
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'alamat' => $resident->family_member->family['address'],
            'status' => $resident->status_kependudukan,
            'warganegara' => $resident->kewarganegaraan,
            "Ke{$resident->kewarganegaraan}" => 'Kewarganegaraan',
            'agama' => $resident->agama,
            'pekerjaan' => $resident->occupation->name,
            'tanggalsurat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'Surat Keterangan KTP Dalam Proses.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 
    public function printSporadik(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $head = FamilyMember::with(['resident'])
            ->where('relation', 'kepala')->firstOrFail();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_sporadik.rtf';
        $replace = [
            'nama_pamong' => $pamong->name,
            'atas_nama' => $pamong->name,
            'denganjalan' => $_GET['perolehjalan'],
            'perolehtahun' => $_GET['perolehtahun'],
            'namasaksiii' => $_GET['namesaksi2'], //'coba tes saksi 2',
            'namasaksii' => $_GET['namesaksi1'], //'coba tes saksi 1',
            'kabb' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'desalurah' => $family->desa->name,
            'camatt' => $family->kecamatan->name,
            'alamat_pemohon' => $family->alamat_lengkap,
            'jalan' => $family->address,
            "dengan {$family->address}" => 'dengan jalan',
            'rtrw' => $family->village_name,
            'nama_des' => option()->desa->name,
            'prov' => option()->provinsi->name,
            'almtds' => $family->village_name,
            'nama_non_warga' => $resident->name,
            'nik_non_warga' => $nik,
            'tempatlahir_pemohon' => $resident->birth_place,
            'tanggallahir_pemohon' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'pekerjaan_pemohon' => $resident->occupation->name,
            'utara' => $_GET['utara'], //'ini utara',
            'timur' => $_GET['timur'], //'ini timur',
            'selatan' => $_GET['selatan'], //'ini selatan',
            'barat' => $_GET['barat'], //'ini barat',
            'namasaksiii' => $_GET['namesaksi2'], //'coba tes saksi 2',
            'umursaksiii' => $_GET['umursaksi2'], //'coba umur saksi 2',
            'pekerjaansaksiii' => $_GET['kerjaansaksi2'], //'coba pekerjaan saksi 2',
            'alamatsaksiii' => $_GET['alamatsaksi2'], //'coba alamat saksi 2',
            'umursaksii' => $_GET['umursaksi1'], //'coba umur saksi 1',
            'pekerjaansaksii' => $_GET['kerjaansaksi1'], //'coba pekerjaan saksi 1',
            'alamatsaksii' => $_GET['alamatsaksi1'], //'coba alamat saksi 1',
            'nib' => $_GET['nib'], //'coba nib 1212',
            'statustanah' => $_GET['statustanah'], //'status aman',
            'tanahuntuk' => $_GET['dipergunakanuntuk'], //'tanah ini untuk ....',
            'peroleh_dari' => $_GET['perolehdari'],
            'luashak' => $_GET['luas'], //'luashak',
            'umur_pemohon' => $resident->birthday->age,
            'tgl_surat' => date('d M Y'),
            'jabatan' => $pamong->jabatan,
            'form_pamong_nip' => $pamong->nip,
            'nama' => $resident->name,
        ];
        $filename = 'SuratPernyataanSporadik.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printPerdupNikah(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $head = FamilyMember::with(['resident'])
            ->where('relation', 'kepala')->firstOrFail();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_permohonan_duplikat_surat_nikah.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'judul_surat' => 'Surat Permohonan Duplikat Surat Nikah',
            'tglsurat' => Carbon::now()->format('d M Y'),
            'nomorsurat' => $request->no_surat,
            'tahun' => date('Y'),
            'nama' => $resident->name,
            "{$resident->name}nya" => 'namanya',
            'no_ktp' => $nik,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'agama' => $resident->agama,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->resident['name'],
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'nationality' => $resident->kewarganegaraan,
            'form_keterangan' => 'TEST',
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
            'tglnikah' => Carbon::createFromFormat('Y-m-d', $request->tgl_nikah)->format('d M Y'),
            'pasangan' => $request->nama_pasangan
        ];
        $filename = 'surat_permohonan_duplikat_surat_nikah.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printPerKK(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $head = FamilyMember::with(['resident'])
            ->where('relation', 'kepala')->firstOrFail();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_permohonan_kartu_keluarga.rtf';
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'prov_pemerintah' => option()->provinsi->name,
            'almtds' => option()->office_address,
            'kab' => $family->kabupaten->name,
            'Sebutan_kabupaten' => '',
            'usia' => $resident->birthday->age,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'judul_surat' => 'Surat Permohonan Kartu Keluarga',
            'tglsurat' => Carbon::now()->format('d M Y'),
            'nomorsurat' => $request->no_surat,
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'alamat' => $family->alamat,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'agama' => $resident->agama,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->resident['name'],
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'nationality' => $resident->kewarganegaraan,
            'form_keterangan' => 'TEST',
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'surat_permohonan_kk.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printPerPKK(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $head = FamilyMember::with(['resident'])
            ->where('relation', 'kepala')->firstOrFail();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_permohonan_perubahan_kartu_keluarga.rtf';
        $replace = [
            'Sebutan_kabupaten' => '',
            'Sebutan_desa' => '',
            'sebutan_' => '',
            'nama_kab' => option()->kabupaten->name,
            'nama_kec' => option()->kecamatan->name,
            'nama_des' => option()->desa->name,
            'nama_provinsi' => option()->provinsi->name,
            'kab' => $family->kabupaten->name,
            'usia' => $resident->birthday->age,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'alamat' => $family->alamat,
            'almtds' => option()->office_address,
            'judul_surat' => 'Surat Permohonan Perubahan Kartu Keluarga',
            'tglsurat' => Carbon::now()->format('d M Y'),
            'nomorsurat' => $request->no_surat,
            'tahun' => date('Y'),
            'nama' => $resident->name,
            'no_ktp' => $nik,
            'tempatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'sex' => $resident->jenkel,
            'agama' => $resident->agama,
            'status' => $resident->status_kependudukan,
            'no_kk' => $resident->family_member->family['no_kk'],
            'kepala_kk' => $head->resident['name'],
            'pendidikan' => $resident->education->name,
            'pekerjaan' => $resident->occupation->name,
            'nationality' => $resident->kewarganegaraan,
            'form_keterangan' => 'TEST',
            'jabatan' => $pamong->jabatan,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'surat_permohonan_perubahan_kk.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printAkta(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_permohonan_akta.rtf';
        $replace = [
            'Sebutan_kabupaten' => '',
            'sebutan_desa' => 'DESA',
            'kab_pemerintah' => option()->kabupaten->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'almtds' => option()->office_address,
            'nama_kab' => $family->kabupaten->name,
            'nama_kec' => $family->kecamatan->name,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'form_tempatlahir_anak' => $_GET['tmptlahir'],
            'form_tanggallahir_anak' => Carbon::createFromFormat('Y-m-d', $_GET['tgllahir'])->format('d M Y'),
            'form_alamat_anak' => $_GET['formalmat'],
            'nomor_surat' => $_GET['no_surat'],
            'tanggalsurat' => date('d M Y'),
            'tglsurat' => date('d M Y'),
            'tahun' => date('Y'),
            'pekerjaan' => $resident->occupation->name,
            'alamat' => $resident->family_member->family['address'],
            'no_ktp' => $nik,
            'jabatan' => $pamong->jabatan,
            'form_nama_anak' => $_GET['namanak'],
            'tampatlahir' => $resident->birth_place,
            'tanggallahir' => $resident->birthday->format('d M Y'),
            'form_harilahir_anak' => $_GET['hari'],
            'form_nama_ayah' => $_GET['namayah'],
            'form_nama_ibu' => $_GET['namibu'],
            'form_nama_ortu' => $_GET['almatortu'],
            'kepala_kk' => $head->name,
            'nama_penduduk' => $resident->name,
            'nip' => $pamong->nip,
            'pamong' => $pamong->name,
        ];
        $filename = 'Surat Permohonan Akta.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    // done 2
    public function printCerai(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::with(['family_member', 'family_member.family'])
            ->where('nik', $nik)->firstOrFail();
        $family = Family::where('no_kk', $resident->family_member->family->no_kk)->firstOrFail();
        $head = $family->familyHead();
        $family = Family::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])->firstOrFail();
        $file = 'surat_permohonan_cerai.rtf';
        $wife = Resident::where('nik', $request->nik_istri)->firstOrFail();
        $replace = [
            'kab_pemerintah' => option()->kabupaten->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'alamat_des' => option()->office_address,
            'sebutan_kabupaten' => '',
            'SEBUTAN_KABUPATEN' => '',
            'Sebutan_kabupaten' => '',
            'Sebutan_kab' => '',
            'Sebutan_desa' => '',
            'nama_pamong' => $pamong->name,
            'pamong_nip' => $pamong->nip,
            'nama_kab' => $family->kabupaten->name,
            'nama_kec' => $family->kecamatan->name,
            'ttl_suami' => "{$resident->birth_place}, {$resident->birthday->format('d M Y')}",
            'tempatlahir_istri' => $wife->birth_place,
            'nik_istri' => $wife->nik,
            'tanggallahir_istri' => $wife->birthday->format('d M Y'),
            'pekerjaan_istri' => $wife->occupation->name,
            'agama_istri' => $wife->agama,
            'nama_istri' => $wife->name,
            'kab' => $family->kabupaten->name,
            'kec' => $family->kecamatan->name,
            'nama_des' => $family->desa->name,
            'des' => $family->desa->name,
            'prov' => $family->provinsi->name,
            'nomor_surat' => $_GET['no_surat'],
            'agama' => $resident->agama,
            'tgl_surat' => date('d M Y'),
            'tahun' => date('Y'),
            'pekerjaan' => $resident->occupation->name,
            'alamat_istri' => $resident->family_member->family->alamat,
            'alamat' => $resident->family_member->family->alamat,
            'no_ktp' => $nik,
            'jabatan' => $pamong->jabatan,
            'form_sebab' => $_GET['sebab'],
            'kepala_kk' => $head->name,
            'nama' => $resident->name,
        ];
        $filename = 'Surat Permohonan Cerai.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    public function printPerDupKelahiran(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::where('nik', $nik)->firstOrFail();
        $father = Resident::where('nik', $request->nik_ayah)->firstOrFail();
        $mother = Resident::where('nik', $request->nik_ibu)->firstOrFail();
        $child = Resident::where('nik', $request->nik_anak)->firstOrFail();
        $family = $father->family_member->family;

        $head = $family->familyHead();
        $file = 'surat_permohonan_duplikat_kelahiran.rtf';
        $replace = [
            'judul_surat' => 'Surat Permohonan Duplikat Kelahiran',

            'kab_pemerintah' => option()->kabupaten->name,
            'prov_pemerintah' => option()->provinsi->name,
            'kec_pemerintah' => option()->kecamatan->name,
            'des_pemerintah' => option()->desa->name,
            'alamat_des' => option()->office_address,

            'nama_kab' => $family->kabupaten->name,
            'nama_kec' => $family->kecamatan->name,
            'nama_des' => $family->desa->name,
            'nomor_surat' => $request->no_surat,
            'd_nama_ibu' => $mother->name,
            'd_tanggallahir_ibu' => $mother->birthday->format('d M Y'),
            'd_nik_ibu' => $mother->nik,
            'd_pekerjaan_ibu' => $mother->occupation->name,
            'd_alamat_ibu' => $family->alamat,
            'd_nama_ayah' => $father->name,
            'd_tanggallahir_ayah' => $father->birthday->format('d M Y'),
            'd_nik_ayah' => $father->nik,
            'd_pekerjaan_ayah' => $father->occupation->name,
            'd_alamat_ayah' => $family->alamat,
            'form_nama_pelapor' => $resident->name,
            'form_nik_pelapor' => $resident->name,
            'form_sex_pelapor' => $resident->jenkel,
            'form_tempatlahir_pelapor' => $resident->birth_place,
            'form_tanggallahir_pelapor' => $resident->birthday->format('d M Y'),
            'form_pek_pelapor' => $resident->occupation->name,
            'form_alamat_pelapor' => $resident->family->alamat_lengkap,
            'jabatan' => $pamong->jabatan,
            'nama_pamong' => $pamong->name,
            'pamong_nip' => $pamong->nip,
            'nama' => $child->name,
            'no_ktp' => $child->nik,
            'sex' => $child->jenkel,
            'agama' => $child->agama,
            'alamat' => $child->family->alamat,
            'form_hari_bayi' => $request->hari,
            'tanggallahir' => $child->birthday->format('d M Y'),
            'form_jam_bayi' => $request->jam,
            'form_tempatlahir_bayi' => $request->tempat_lahir,
            'tahun' => date('Y'),
            'tgl_surat' => date('d M Y'),
        ];
        $filename = 'Surat Permohonan Duplikat Kelahiran.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    public function printPerAkta(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $resident = Resident::where('nik', $nik)->firstOrFail();
        $father = Resident::where('nik', $request->nik_ayah)->firstOrFail();
        $mother = Resident::where('nik', $request->nik_ibu)->firstOrFail();
        $family = $resident->family;

        $file = 'surat_pernyataan_akta.rtf';
        $replace = [
            'judul_surat' => 'Surat Pernyataan Akta',
            'ttl_penduduk' => "{$resident->birth_place}, {$resident->birthday->format('d M Y')}",
            'nama_kab' => $family->kabupaten->name,
            'nama_kec' => $family->kecamatan->name,
            'nama_des' => $family->desa->name,
            'nama_provinsi' => $family->provinsi->name,
            'alamat_des' => $family->village_name,
            'nomor_surat' => $request->no_surat,
            'nama_ibu' => $mother->name,
            'ibu_nik' => $mother->nik,
            'nama_ayah' => $father->name,
            'ayah_nik' => $father->nik,
            'alamat' => $resident->family->alamat,
            'jabatan' => $pamong->jabatan,
            'nama_pamong' => $pamong->name,
            'pamong_nip' => $pamong->nip,
            'nama' => $resident->name,
            'sex' => $resident->jenkel,
            'alamat' => $resident->family->alamat,
            'tahun' => date('Y'),
            'tgl_surat' => date('d M Y'),
        ];
        $filename = 'Surat Pernyataan Akta.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }
}
