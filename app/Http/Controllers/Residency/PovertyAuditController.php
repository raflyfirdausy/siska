<?php

namespace App\Http\Controllers\Residency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Residency\Resident;
use App\Models\Residency\Poverty;
use App\Models\Residency\PovertyAudit;
use App\Exports\PovertyAuditsExport;
use Maatwebsite\Excel\Facades\Excel;

class PovertyAuditController extends Controller
{
    public function print()
    {
        $audits = PovertyAudit::with('resident')->get();
        return view('kependudukan.kemiskinan.audit.cetak', compact('audits'));
    }

    public function export()
    {
        return Excel::download(new PovertyAuditsExport, 'data-audit-kemiskinan.xlsx');
    }

    public function index(Request $request)
    {
        $audits = PovertyAudit::with('resident');
        
        if ($request->has('q')) {
            $q = $request->input('q');
            $audits = $audits->whereHas('resident', function($query) use ($q) {
                return $query->where('nik', 'LIKE', "%$q%")
                    ->orWhere('name', 'LIKE', "%$q%");
            });
        }
        
        $audits = $audits->paginate(50);

        return view('kependudukan.kemiskinan.audit.index', compact('audits'));
    }

    public function create()
    {
        $questions = [
            'Apakah luas bangunan tempat tinggal kurang dari 8 m2 per orang?',
            'Apakah jenis lantai tempat tinggal terbuat dari tanah/bambu/kayu murah?',
            'Apakah jenis dinding tempat terbuat dari bambu/rumbia/kayu berkualitas rendah/tembok tanpa diplester?',
            'Apakah tidak memiliki fasilitas buang air besar atau bersamaan dengan rumah tangga lain?',
            'Apakah sumber penerangan rumah tangga tidak menggunakan listrik?',
            'Apakah sumber air minum berasal dari sumur / mata air yang tidak terlindungi (sungai / air hujan)?',
            'Apakah bahan bakar untuk memasak sehari - hari adalah kayu bakar / arang / minyak tanah?',
            'Apakah daging / susu / ayam hanya dikonsumsi sekali dalam seminggu?',
            'Apakah pembelian satu stel pakaian baru hanya dilakukan sekali dalam setahun?',
            'Apakah hanya sanggup makan sebanyak satu / dua kali dalam sehari?',
            'Apakah tidak sanggup membayar biaya pengobatan di puskesmas / poliklinik?',
            'Apakah sumber penghasilan kepada rumah tangga adalah petani dengan luas lahan 500 m2, buruh tani, nelayan, buruh bangunan, buruh perkebunan, dan atau pekerjaan lainnya dengan pendapatan dibawah Rp. 600.000, per bulan?',
            'Apakah pendidikan tertinggi kepala rumah tangga adalah diantara tidak sekolah / tidak tamat SD / hanya SD?',
            'Apakah tidak memiliki tabungan / barang yang mudah dijual dengan minimal Rp. 500.000, seperti sepeda motor kredit / non kredit, emas, ternak, kapal motor, atau barang modal lainnya?',
        ];

        return view('kependudukan.kemiskinan.audit.tambah', compact('questions'));
    }

    public function store(Request $request)
    {
        // format name dari pertanyaan adalah 'answer-n' dimana n dimulai dari 1 hingga 14
        $answers = collect(range(1, 14))->map(function($val) {
            return "answer-" . strval($val);
        });

        // digunakan untuk validasi tiap 'answer-n' dan nik
        $validation = $answers->reduce(function($carry, $item) {
            $carry[$item] = 'required|in:0,1';

            return $carry;
        }, collect([]))
        ->merge([
            'nik' => 'required|numeric|exists:residents,nik',
        ])->toArray();

        $request->validate($validation);

        $resident = Resident::where('nik', $request->nik)->firstOrFail();

        $answers = collect($request->only($answers->toArray()))->values()->toArray();
        // dinyatakan miskin jika ada salah satu pertanyaan yang dijawab dengan jawaban 'iya' atau '1'
        $result = in_array('1', $answers);
        

        $audit = PovertyAudit::create([
            'resident_id' => $resident->id,
            'answer' => implode('', $answers),
            'result' => $result ? 'miskin' : 'bukan_miskin',
        ]);

        // menambahkan data kemiskinan jika audit saat ini dinyatakan miskin
        // dan belum masuk data kemiskinan
        if ($result && !$resident->poverty) {
            $poverty = Poverty::create([
                'resident_id' => $resident->id,
            ]);
        }
        // hapus data kemiskinan dari penduduk jika dinyatakan tidak miskin
        // namun sebelumnya dinyatakan miskin
        else if (!$result && $resident->poverty) {
            $resident->poverty()->delete();
        }

        $result = $result ? 'miskin' : 'tidak miskin';
        return redirect('/audit-kemiskinan')->with('success', "Audit selesai dengan hasil yang menyatakan bahwa penduduk tersebut $result!");
    }

    public function destroy(Request $request, $id)
    {
        $audit = PovertyAudit::findOrFail($id);

        $audit->delete();

        return redirect('/audit-kemiskinan')->with('success', 'Penghapusan data audit kemiskinan berhasil dilakukan!');
    }
}
