<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Helpers\TemplateReplacer;
use App\Models\General\Official;
use App\Models\Option;
use App\Models\Surat;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\Client;

class ModulKependudukanController extends Controller
{

    public function getTanggalIndo($tanggal, $cetak_hari = false)
    {
        $hari = array(
            1 =>    'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );

        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split       = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }

    public function getLink($nik)
    {
        //WANADADI
        $link   = "http://durenmas.banjarnegarakab.go.id:8081/ws_server/get_json/10_wanadadi/carinik?USER_ID=PRATAMAYUDHASANTOSA&PASSWORD=10_wanadadi&NIK=$nik";

        //BEJI
        // $link   = "http://durenmas.banjarnegarakab.go.id:8081/ws_server/get_json/beji_pandanarum/carinik?USER_ID=ARIFIN&PASSWORD=19beji&NIK=$nik";

        //TAPEN
        // $link   = "http://durenmas.banjarnegarakab.go.id:8081/ws_server/get_json/10_tapen/carinik?USER_ID=WEGIGPUJADI&PASSWORD=10_wegigpujadi_2002&NIK=$nik";        

        // $link   = "http://103.110.4.34:8081/ws_server/get_json/10_wanadadi/carinik?USER_ID=PRATAMAYUDHASANTOSA&PASSWORD=10_wanadadi&NIK=$nik";
        // $link   = "https://durenmas.banjarnegarakab.go.id/ws_server/get_json/10_wanadadi/carinik?USER_ID=PRATAMAYUDHASANTOSA&PASSWORD=10_wanadadi&NIK=$nik";

        // if ($nik == "3304061303090001" || $nik == "3304062007780002" || $nik == "3304064308830001") {
        //     $link = asset("json/$nik.json");
        // } else {
        //     // $linkRequest = asset("json/tidak_ditemukan.json");
        //     return redirect('/modul-kependudukan');
        // }

        return $link;
    }

    public function getContent($url)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            "GET",
            $url
        );
        return ($response->getBody());
        // die();


        // $ch = curl_init();        
        // curl_setopt($ch, CURLOPT_URL, $url);              
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
        // $result = curl_exec($ch);    
        // curl_close($ch);

        // echo $result;
        // die();
    }

    public function cekNoSurat(Request $requset)
    {
        return response()->json([
            'count' => Surat::where("nomer", $requset->no)->count(),
        ]);
    }

    public function cekNoSurat_($noSurat)
    {
        return response()->json([
            'count' => Surat::where("nomer", $noSurat)->count(),
        ]);
    }

    public function cekNoSuratTerakhir(Request $requset)
    {
        return response()->json([
            'result' => Surat::where("nomer", "LIKE",  "$requset->kode%")->latest('id')->first(),
        ]);
    }

    public function modulKependudukanDetail($nik)
    {
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $officials = Official::all();
        return view('kependudukan.penduduk.modul-kependudukan-lihat', compact('data', 'officials'));
    }

    public function modulKependudukan(Request $request)
    {
        $linkRequest = asset("json/tidak_ditemukan.json");
        if ($request->has('nik')) {
            $nik = $request->input('nik');
            $this->getContent($this->getLink($nik));
            $data = json_decode(file_get_contents($this->getLink($nik)));

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
        $officials = Official::all();
        return view('kependudukan.penduduk.modul-kependudukan', compact('data', 'officials'));
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
            'tanggal_indo' => $this->getTanggalIndo(date('Y-m-d')),
            'pamong' => $pamong->name,
            'nip' => $pamong->nip,
        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_permohonan_pendataan_ulang.rtf';

        $filename = 'SURAT_PERMOHONAN_PENDATAAN_ULANG_' . preg_replace("/[^A-Za-z0-9]/", "_", strtoupper($request->nama_lengkap)) . '_' . $date . '.doc';

        return TemplateReplacer::replace($file, $replace, $filename);
    }

    public function print_keterangan_tanah(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "580 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');

        $replace = [
            'judul_kabupaten'   => substr(option()->kabupaten->name, 5),
            'judul_kecamatan'   => strtoupper(option()->kecamatan->name),
            'judul_desa'        => strtoupper(option()->desa->name),
            'kop_jenis'         => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa'        => $alamatDesaLengkap,
            'nomor_surat'       => $noSurat,
            'jabatan'           => $pamong->jabatan,
            'desa'              => option()->desa->name,
            'kecamatan'         => option()->kecamatan->name,
            'kabupaten'         => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi'          => ucwords(strtolower(option()->provinsi->name)),
            'nik'               => $data->content[0]->NIK,
            'nama'              => $data->content[0]->NAMA_LGKP,
            'tanggal_indo'      => $this->getTanggalIndo(date('Y-m-d')),
            'pamong'            => strtoupper($pamong->name),
            'pemegang'          => $data->content[0]->NAMA_LGKP,

            'BLOK'              => $request->tanah_blok,
            'PERSIL'            => $request->tanah_persil,
            'LUAS_TANAH'        => $request->tanah_luas,
            'LUAS_BANGUNAN'     => $request->bangunan_luas,
            'KET_TANAH'         => $request->tanah_keterangan
        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_tanah.rtf';
        $filename = 'SURAT_KETERANGAN_TANAH_' . preg_replace("/[^A-Za-z0-9]/", "_", $data->content[0]->NAMA_LGKP) . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN TANAH " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN TANAH",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');
        }
    }

    public function print_keterangan_usaha(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "500 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');

        $replace = [
            'judul_kabupaten' => substr(option()->kabupaten->name, 5),
            'judul_kecamatan' => strtoupper(option()->kecamatan->name),
            'judul_desa' => strtoupper(option()->desa->name),
            'kop_jenis' => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa' => $alamatDesaLengkap,
            'nomor_surat' => $noSurat,
            'jabatan' => $pamong->jabatan,
            'desa' => option()->desa->name,
            'kecamatan' => option()->kecamatan->name,
            'kabupaten' => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi' => ucwords(strtolower(option()->provinsi->name)),
            'nik' => $data->content[0]->NIK,
            'nama' => $data->content[0]->NAMA_LGKP,
            'tempat_lahir' => $data->content[0]->TMPT_LHR,
            'tanggal_lahir' => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'warga_negara' => "INDONESIA",
            'agama' => $data->content[0]->AGAMA,
            'jenis_kelamin' => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN' => $data->content[0]->STATUS_KAWIN,
            'PEKERJAAN' => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal' => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,
            'alamat_desa_tinggal' => option()->desa->name,
            'golongan_darah' => $data->content[0]->GOL_DARAH == "TIDAK TAHU" ? "-" : $data->content[0]->GOL_DARAH,
            'keperluan' => $request->keperluan,
            'tanggal_indo' => $this->getTanggalIndo(date('Y-m-d')),
            'pamong' => strtoupper($pamong->name),
            'nip' => $pamong->nip,
            'pemegang' => $data->content[0]->NAMA_LGKP,
            'USAHA_BIDANG' => $request->bidang_usaha,
            'JENIS_USAHA' => $request->jenis_usaha,
            'TAHUN_USAHA' => $request->tahun_usaha
        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_usaha.rtf';
        $filename = 'SURAT_KETERANGAN_USAHA_' . preg_replace("/[^A-Za-z0-9]/", "_", $data->content[0]->NAMA_LGKP) . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN USAHA " . strtoupper($request->jenis_usaha) . "_" . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN USAHA",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
    }

    public function print_keterangan_kematian(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "474.3 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');

        $replace = [
            'judul_kabupaten'   => substr(option()->kabupaten->name, 5),
            'judul_kecamatan'   => strtoupper(option()->kecamatan->name),
            'judul_desa'        => strtoupper(option()->desa->name),
            'kop_jenis'         => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa'        => $alamatDesaLengkap,
            'nomor_surat'       => $noSurat,
            'jabatan'           => $pamong->jabatan,
            'desa'              => option()->desa->name,
            'kecamatan'         => option()->kecamatan->name,
            'kabupaten'         => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi'          => ucwords(strtolower(option()->provinsi->name)),

            'nik'               => $data->content[0]->NIK,
            'nama'              => $data->content[0]->NAMA_LGKP,
            'tempat_lahir'      => $data->content[0]->TMPT_LHR,
            'tanggal_lahir'     => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'jenis_kelamin'     => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN'      => $data->content[0]->STATUS_KAWIN,
            'warga_negara'      => "INDONESIA",
            'agama'             => $data->content[0]->AGAMA,
            'pekerjaan'         => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal'    => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,

            'tanggal_indo'      => $this->getTanggalIndo(date('Y-m-d')),
            'pamong'            => strtoupper($pamong->name),
            'nip'               => $pamong->nip,
            'pemegang'          => $data->content[0]->NAMA_LGKP,

            'HARI_TANGGAL'      => $this->getTanggalIndo($request->tanggal_kematian, TRUE),
            'PUKUL_KEMATIAN'    => $request->pukul_kematian,
            'PENYEBAB_KEMATIAN' => $request->penyebab_kematian,
            'TEMPAT_KEMATIAN'   => $request->tempat_kematian

        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_kematian.rtf';
        $filename = 'SURAT_KETERANGAN_KEMATIAN_' . preg_replace("/[^A-Za-z0-9]/", "_", $data->content[0]->NAMA_LGKP) . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN KEMATIAN " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN KEMATIAN",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
    }

    public function print_keterangan_domisili_lembaga(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "474.1 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');
        $defaultKeterangan  =   $request->nama_lembaga . " benar - benar berdomisili dan beroperasi di Desa " . $request->nama_desa .
            " RT " . $request->nomer_RT . " RW " . $request->nomer_RW . ", Kec. " . option()->kecamatan->name .
            ", Kab. " . ucfirst(strtolower(substr(option()->kabupaten->name, 5)));

        $replace = [
            'judul_kabupaten'   => substr(option()->kabupaten->name, 5),
            'judul_kecamatan'   => strtoupper(option()->kecamatan->name),
            'judul_desa'        => strtoupper(option()->desa->name),
            'kop_jenis'         => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa'        => $alamatDesaLengkap,
            'nomor_surat'       => $noSurat,
            'jabatan'           => $pamong->jabatan,
            'desa'              => option()->desa->name,
            'kecamatan'         => option()->kecamatan->name,
            'kabupaten'         => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi'          => ucwords(strtolower(option()->provinsi->name)),

            'nik'               => $data->content[0]->NIK,
            'nama'              => $data->content[0]->NAMA_LGKP,
            'tempat_lahir'      => $data->content[0]->TMPT_LHR,
            'tanggal_lahir'     => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'jenis_kelamin'     => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN'      => $data->content[0]->STATUS_KAWIN,
            'warga_negara'      => "INDONESIA",
            'agama'             => $data->content[0]->AGAMA,
            'pekerjaan'         => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal'    => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,

            'tanggal_indo'      => $this->getTanggalIndo(date('Y-m-d')),
            'pamong'            => strtoupper($pamong->name),
            'nip'               => $pamong->nip,
            'pemegang'          => $data->content[0]->NAMA_LGKP,

            'LEMBAGA_NAMA'      => $request->nama_lembaga,
            'LEMBAGA_ALAMAT'    => "Desa " . $request->nama_desa .
                " RT " . $request->nomer_RT . " RW " . $request->nomer_RW . ", Kec. " . option()->kecamatan->name .
                ", Kab. " . ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'KET_LEMBAGA'       => isset($request->keterangan) ? $request->keterangan : $defaultKeterangan

        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_domisili_lembaga.rtf';
        $filename = 'SURAT_KETERANGAN_DOMISILI_LEMBAGA_' . $request->nama_lembaga . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN DOMISILI LEMBAGA " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN DOMISILI LEMBAGA",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
    }

    public function print_keterangan_domisili(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "474.1 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');
        $defaultKeterangan = "Orang tersebut benar - benar warga Desa " .
            option()->desa->name . " yang berdomisili di " .
            $data->content[0]->ALAMAT . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW .
            ", Kec. " . option()->kecamatan->name . ", Kab. " . ucfirst(strtolower(substr(option()->kabupaten->name, 5)));

        $replace = [
            'judul_kabupaten'   => substr(option()->kabupaten->name, 5),
            'judul_kecamatan'   => strtoupper(option()->kecamatan->name),
            'judul_desa'        => strtoupper(option()->desa->name),
            'kop_jenis'         => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa'        => $alamatDesaLengkap,
            'nomor_surat'       => $noSurat,
            'jabatan'           => $pamong->jabatan,
            'desa'              => option()->desa->name,
            'kecamatan'         => option()->kecamatan->name,
            'kabupaten'         => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi'          => ucwords(strtolower(option()->provinsi->name)),

            'nik'               => $data->content[0]->NIK,
            'nama'              => $data->content[0]->NAMA_LGKP,
            'tempat_lahir'      => $data->content[0]->TMPT_LHR,
            'tanggal_lahir'     => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'jenis_kelamin'     => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN'      => $data->content[0]->STATUS_KAWIN,
            'warga_negara'      => "INDONESIA",
            'agama'             => $data->content[0]->AGAMA,
            'pekerjaan'         => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal'    => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,

            'tanggal_indo'      => $this->getTanggalIndo(date('Y-m-d')),
            'pamong'            => strtoupper($pamong->name),
            'nip'               => $pamong->nip,
            'pemegang'          => $data->content[0]->NAMA_LGKP,

            'DOMISILI_KET'        => isset($request->keterangan) ? $request->keterangan : $defaultKeterangan

        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_domisili.rtf';
        $filename = 'SURAT_KETERANGAN_DOMISILI_' . preg_replace("/[^A-Za-z0-9]/", "_", $data->content[0]->NAMA_LGKP) . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN DOMISILI " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN DOMISILI",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
    }

    public function print_keterangan_beda_nama_identitas(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "474 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');

        $replace = [
            'judul_kabupaten'   => substr(option()->kabupaten->name, 5),
            'judul_kecamatan'   => strtoupper(option()->kecamatan->name),
            'judul_desa'        => strtoupper(option()->desa->name),
            'kop_jenis'         => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa'        => $alamatDesaLengkap,
            'nomor_surat'       => $noSurat,
            'jabatan'           => $pamong->jabatan,
            'desa'              => option()->desa->name,
            'kecamatan'         => option()->kecamatan->name,
            'kabupaten'         => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi'          => ucwords(strtolower(option()->provinsi->name)),

            'nik'               => $data->content[0]->NIK,
            'ABCNAMA'           => $data->content[0]->NAMA_LGKP,
            'tempat_lahir'      => $data->content[0]->TMPT_LHR,
            'tanggal_lahir'     => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'jenis_kelamin'     => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN'      => $data->content[0]->STATUS_KAWIN,
            'warga_negara'      => "INDONESIA",
            'agama'             => $data->content[0]->AGAMA,
            'pekerjaan'         => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal'    => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,

            'tanggal_indo'      => $this->getTanggalIndo(date('Y-m-d')),
            'pamong'            => strtoupper($pamong->name),
            'nip'               => $pamong->nip,
            'pemegang'          => $data->content[0]->NAMA_LGKP,

            'BENAR_NIK'         => $request->benar_nik,
            'BNR_NM'            => $request->benar_nama,
            'BENAR_TEMPAT_LAHIR' => $request->benar_tempat_lahir,
            'BENAR_TGL_LAHIR'   => $this->getTanggalIndo($request->benar_tanggal_lahir),
            'BENAR_JENIS_KELAMIN' => $request->benar_jenis_kelamin,
            'benar_stts_kwn'    => $request->benar_status_perkawinan,
            'BENAR_WARGA_NEGARA' => $request->benar_warga_negara,
            'BENAR_AGAMA'       => $request->benar_agama,
            'BENAR_PEKERJAAN'   => $request->benar_pekerjaan,
            'BENAR_ALAMAT'      => $request->benar_alamat

        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_beda_nama_identitas.rtf';

        $filename = 'SURAT_KETERANGAN_BEDA_NAMA_IDENTITAS_' . preg_replace("/[^A-Za-z0-9]/", "_", $request->benar_nama) . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN BEDA IDENTITAS " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN BEDA IDENTITAS",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
    }


    public function print_keterangan_pengantar(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "474 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');

        $replace = [
            'judul_kabupaten' => substr(option()->kabupaten->name, 5),
            'judul_kecamatan' => strtoupper(option()->kecamatan->name),
            'judul_desa' => strtoupper(option()->desa->name),
            'kop_jenis' => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa' => $alamatDesaLengkap,
            'nomor_surat' => $noSurat,
            'jabatan' => $pamong->jabatan,
            'desa' => option()->desa->name,
            'kecamatan' => option()->kecamatan->name,
            'kabupaten' => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi' => ucwords(strtolower(option()->provinsi->name)),
            'nik' => $data->content[0]->NIK,
            'nama' => $data->content[0]->NAMA_LGKP,
            'tempat_lahir' => $data->content[0]->TMPT_LHR,
            'tanggal_lahir' => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'warga_negara' => "INDONESIA",
            'agama' => $data->content[0]->AGAMA,
            'jenis_kelamin' => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN' => $data->content[0]->STATUS_KAWIN,
            'pekerjaan' => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal' => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,
            'alamat_desa_tinggal' => option()->desa->name,
            'golongan_darah' => $data->content[0]->GOL_DARAH == "TIDAK TAHU" ? "-" : $data->content[0]->GOL_DARAH,
            'keperluan' => $request->keperluan,
            // 'mulai_berlaku' => Carbon::createFromFormat('Y-m-d', $request->mulai_berlaku)->format('d M Y'),
            // 'tgl_akhir' => Carbon::createFromFormat('Y-m-d', $request->tgl_akhir)->format('d M Y'),
            'tanggal_indo' => $this->getTanggalIndo(date('Y-m-d')),
            'pamong' => strtoupper($pamong->name),
            'nip' => $pamong->nip,
            'pemegang' => $data->content[0]->NAMA_LGKP
        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_pengantar.rtf';

        $filename = 'SURAT_PENGANTAR_' . preg_replace("/[^A-Za-z0-9]/", "_", $data->content[0]->NAMA_LGKP) . '_' . $date . '.doc';

        $kodeStatus = null;
        if ($request->kode_keperluan == "2") {
            $kodeStatus = "SURAT PENGANTAR KTP";
        } else if ($request->kode_keperluan == "3") {
            $kodeStatus = "SURAT PENGANTAR SKCK";
        } else {
            $kodeStatus = "SURAT PENGANTAR UMUM";
        }

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => $kodeStatus . " " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => $kodeStatus,
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
    }

    public function print_keterangan_tidak_mampu(Request $request, $nik)
    {
        $pamong = Official::find($request->pamong_id);
        $data = json_decode(file_get_contents($this->getLink($nik)));
        $alamatDesaLengkap = option()->office_address . ", " . option()->kecamatan->name . ", Telp " . option()->phone . " Kode Pos " . option()->postal_code;
        $noSurat = "400 / " . $request->no_surat . " / Ds. " . ucfirst(strtolower(option()->desa->name)) . " / " . date('Y');
        $defaultKeterangan = "Bahwa orang tersebut diatas benar - benar berasal dari keluarga tidak mampu ";

        $replace = [
            'judul_kabupaten'   => substr(option()->kabupaten->name, 5),
            'judul_kecamatan'   => strtoupper(option()->kecamatan->name),
            'judul_desa'        => strtoupper(option()->desa->name),
            'kop_jenis'         => $pamong->jabatan == "Kepala Desa" ? "KEPALA DESA" : "SEKRETARIAT DESA",
            'alamatdesa'        => $alamatDesaLengkap,
            'nomor_surat'       => $noSurat,
            'jabatan'           => $pamong->jabatan,
            'desa'              => option()->desa->name,
            'kecamatan'         => option()->kecamatan->name,
            'kabupaten'         => ucfirst(strtolower(substr(option()->kabupaten->name, 5))),
            'provinsi'          => ucwords(strtolower(option()->provinsi->name)),

            'nik'               => $data->content[0]->NIK,
            'nama'              => $data->content[0]->NAMA_LGKP,
            'tempat_lahir'      => $data->content[0]->TMPT_LHR,
            'tanggal_lahir'     => $this->getTanggalIndo($data->content[0]->TGL_LHR),
            'jenis_kelamin'     => $data->content[0]->JENIS_KLMIN,
            'STATUS_KAWIN'      => $data->content[0]->STATUS_KAWIN,
            'warga_negara'      => "INDONESIA",
            'agama'             => $data->content[0]->AGAMA,
            'pekerjaan'         => $data->content[0]->JENIS_PKRJN,
            'alamat_tinggal'    => ucwords(strtolower($data->content[0]->ALAMAT)) . " RT " . $data->content[0]->NO_RT . " RW " .  $data->content[0]->NO_RW,

            'tanggal_indo'      => $this->getTanggalIndo(date('Y-m-d')),
            'pamong'            => strtoupper($pamong->name),
            'nip'               => $pamong->nip,
            'pemegang'          => $data->content[0]->NAMA_LGKP,

            'SKTM_KETERANGAN'   => isset($request->keterangan) ? $request->keterangan : $defaultKeterangan

        ];

        $date = date('d_M_Y_H_i_s', time());
        $file = 'surat_keterangan_tidak_mampu.rtf';

        $filename = 'SURAT_KETERANGAN_TIDAK_MAMPU_' . preg_replace("/[^A-Za-z0-9]/", "_", $data->content[0]->NAMA_LGKP) . '_' . $date . '.doc';

        if (json_decode($this->cekNoSurat_($noSurat)->getContent())->count == 0) {
            Surat::create([
                "nomer"     => $noSurat,
                "tanggal"   => date("Y-m-d"),
                "perihal"   => "SURAT KETERANGAN TIDAK MAMPU " . $data->content[0]->NAMA_LGKP,
                "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
                "type"      => "SURAT KETERANGAN TIDAK MAMPU",
                "jenis"     => "keluar",
                "nik"       => $nik
            ]);
            return TemplateReplacer::replace($file, $replace, $filename);
        } else {
            return redirect('/modul-kependudukan/detail/' . $nik)->with('success', 'Gagal membuat surat, Nomor surat tidak boleh sama dengan nomor surat sebelumnya');;
        }
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
        $file = asset("/laporan_statistik/laporan-statistik-kependudukan-desa-tlagawera-banjarnegara-banjarnegara-2019-1.xls");

        $headers = array(
            'Content-Type: application/vnd.ms-excel',
        );
        return response()->download($file, 'laporan-statistik-kependudukan-desa-tlagawera-banjarnegara-banjarnegara-2019-1.xls', $headers);
    }
}
