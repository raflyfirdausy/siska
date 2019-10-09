<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Helpers\TemplateReplacer;
use App\Models\General\Official;

class ModulKependudukanController extends Controller
{
    //
    public function modulKependudukanDetail($nik)
    {
        // $linkRequest = "http://localhost/tes/request.php?nik=";
        // $linkRequest = "http://10.33.4.24:8081/ws_server/get_json/tlagawera/carinik?USER_ID=TLAGAWERA&PASSWORD=12345&NIK=";
        //3304061303090001
        if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
            $linkRequest = asset("json/$nik.json");
        } else {
            // $linkRequest = asset("json/tidak_ditemukan.json");
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
        // die(url('/'));
        // $linkRequest = "http://localhost/tes/request.php?nik=";
        // $linkRequest = "http://10.33.4.24:8081/ws_server/get_json/tlagawera/carinik?USER_ID=TLAGAWERA&PASSWORD=12345&NIK=";
        $linkRequest = asset("json/tidak_ditemukan.json");

        if ($request->has('nik')) {
            $nik = $request->input('nik');
            if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
                $linkRequest = asset("json/$nik.json");
            } else {
                $linkRequest = asset("json/tidak_ditemukan.json");
            }
            // $data = json_decode(file_get_contents($linkRequest . $nik));
            $data = json_decode(file_get_contents($linkRequest));

            if (!isset($data->content->RESPON)) {
                $bday = new \DateTime($data->content[0]->TGL_LHR); // Your date of birth
                $today = new \Datetime(date('Y-m-d'));
                $diff = $today->diff($bday);

                $data->content[0]->AGE = $diff->y;
            }
            $data->status = !isset($data->content->RESPON) ? 200 : 404;
        } else {
            $data = json_decode(file_get_contents($linkRequest));
            $data->status = 400;
        }

        //die(json_encode($data));
        // die(asset());
        $officials = Official::all();
        return view('kependudukan.penduduk.modul-kependudukan', compact('data', 'officials'));
    }

    public function print_keterangan_pengantar(Request $request, $nik)
    {
        // die("haha");
        $pamong = Official::find($request->pamong_id);


        if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
            $linkRequest = asset("json/$nik.json");
        } else {
            // $linkRequest = asset("json/tidak_ditemukan.json");
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

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_pengantar.rtf';
        $filename = 'SURAT_PENGANTAR_' . $data->content[0]->NAMA_LGKP . '_' . $date . '.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    public function print_keterangan_data_hilang(Request $request)
    {
        $pamong = Official::find($request->pamong_id);
        $alamatDesaLengkap = option()->office_address . ", Desa " . option()->desa->name . " Telp " . option()->phone . " Kode Pos " . option()->postal_code;

        $replace = [
            'judul_kabupaten' => substr(option()->kabupaten->name, 5),
            'judul_kecamatan' => strtoupper(option()->kecamatan->name),
            'judul_desa' => strtoupper(option()->desa->name),
            'alamatdesa' => $alamatDesaLengkap,
            'nomor_surat' => $request->nomor_surat,
            'jabatan' => $pamong->jabatan,
            'desa' => option()->desa->name,
            'kecamatan' => option()->kecamatan->name,
            'kabupaten' => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi' => ucwords(strtolower(option()->provinsi->name)),
            'Nik' => $request->nik,
            'nama' => strtoupper($request->nama_lengkap),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir)->format('d M Y'),
            'warga_negara' => $request->kewarganegaraan,
            'agama' => $request->agama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => strtoupper($request->pekerjaan),
            'alamat_tinggal' => ucwords(strtolower($request->alamat)),
            'alamat_desa_tinggal' => option()->desa->name,
            'golongan_darah' => $request->golongan_darah == "TIDAK TAHU" ? "-" : $request->golongan_darah,
            'status_perkawinan' => $request->status_perkawinan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'tanggal_indo' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->format('d M Y'),
            'pamong' => $pamong->name,
            'nip' => $pamong->nip,
        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_permohonan_pendataan_ulang.rtf';
        $filename = 'SURAT_PERMOHONAN_PENDATAAN_ULANG_' . strtoupper($request->nama_lengkap) . '_' . $date . '.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    public function statistikKependudukan()
    {

        // die(json_encode($occupations));

        $jumlahJiwa = array(
            array(
                "label" => "Pria",
                "value" => 1604
            ),
            array(
                "label" => "Wanita",
                "value" => 1481
            )
        );

        $jumlahKepalaKeluarga = array(
            array(
                "label" => "Pria",
                "value" => 892
            ),
            array(
                "label" => "Wanita",
                "value" => 122
            )
        );

        $jumlahKepemilikanKartuKeluarga = array(
            array(
                "label" => "Pria",
                "value" => 872
            ),
            array(
                "label" => "Wanita",
                "value" => 92
            )
        );


        return view('kependudukan.penduduk.statistik-kependudukan', compact(
            'jumlahJiwa',
            'jumlahKepalaKeluarga',
            'jumlahKepemilikanKartuKeluarga'
        ));
    }

    public function exportStatistikKependudukan()
    {
        $file = public_path() . "/laporan_statistik/laporan-statistik-kependudukan-desa-tlagawera-banjarnegara-banjarnegara-2019-1.xls";

        $headers = array(
            'Content-Type: application/vnd.ms-excel',
        );
        return response()->download($file, 'laporan-statistik-kependudukan-desa-tlagawera-banjarnegara-banjarnegara-2019-1.xls', $headers);
    }
}
