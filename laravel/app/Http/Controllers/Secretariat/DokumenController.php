<?php

namespace App\Http\Controllers\Secretariat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengundangan_perdes;
use App\Models\Pengundangan_perkades;
use App\Models\Perdes;
use App\Models\Perkades;
use App\Models\Sk_bpd;
use Illuminate\Support\Facades\DB;
use App\Models\Sk_kades;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DokumenController extends Controller
{
    public function getDataSkKades(Request $request, $order = "DESC")
    {
        $sk  = Sk_kades::orderBy('created_at', $order);
        if (
            $request->input('q') != null ||
            $request->input('bulan') != null ||
            $request->input('tahun') != null
        ) {
            $q      = $request->input('q');
            $bulan  = $request->input('bulan');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $sk->where(function ($query) use ($q) {
                    $query
                        ->where('no_kades', 'LIKE', "%$q%")
                        ->orWhere('tgl_kades', 'LIKE', "%$q%")
                        ->orWhere('tentang', 'LIKE', "%$q%")
                        ->orWhere('uraian', 'LIKE', "%$q%")
                        ->orWhere('no_diundangkan', 'LIKE', "%$q%")
                        ->orWhere('tgl_diundangkan', 'LIKE', "%$q%")
                        ->orWhere('keterangan', 'LIKE', "%$q%");
                });
            }

            if ($bulan != "" && $bulan != "semua") {
                $sk->where(function ($query2) use ($bulan) {
                    $query2->whereMonth("created_at", "=", $bulan);
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $sk->where(function ($query3) use ($tahun) {
                    $query3->whereYear("created_at", "=", $tahun);
                });
            }
        }
        return $sk;
    }

    public function getSkKades(Request $request)
    {
        $sk = $this->getDataSkKades($request);
        $sk = $sk->paginate(50);
        $tahun  = Sk_kades::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $ket    = [
            "q"     => $request->input('q'),
            "bulan" => $request->input('bulan'),
            "tahun" => $request->input('tahun')
        ];
        return view('dokumen_desa.sk_kades', compact(
            'sk',
            'tahun',
            'ket'
        ));
    }

    public function addSkKades(Request $request)
    {
        Sk_kades::create([
            "no_kades"          => $request->input('no_kades'),
            "tgl_kades"         => $request->input('tgl_kades'),
            "tentang"           => $request->input('tentang'),
            "uraian"            => $request->input('uraian'),
            "no_diundangkan"    => $request->input('no_diundangkan'),
            "tgl_diundangkan"   => $request->input('tgl_diundangkan'),
            "keterangan"        => $request->input('keterangan')
        ]);
        return redirect('/surat-keputusan-kades')->with('success', 'Penambahan Surat Keputusan Kepala Desa
        berhasil dilakukan!');
    }

    public function editSkKades(Request $request)
    {        
        $surat = Sk_kades::where('id', $request->input("id_sk"))->firstOrFail();
        $surat->update([
            "no_kades"          => $request->input('no_kades'),
            "tgl_kades"         => $request->input('tgl_kades'),
            "tentang"           => $request->input('tentang'),
            "uraian"            => $request->input('uraian'),
            "no_diundangkan"    => $request->input('no_diundangkan'),
            "tgl_diundangkan"   => $request->input('tgl_diundangkan'),
            "keterangan"        => $request->input('keterangan')
        ]);
        return redirect('/surat-keputusan-kades')->with('success', 'Edit Surat Keputusan Kepala Desa
        berhasil dilakukan!');
    }

    public function hapusSkKades(Request $request)
    {
        $surat = Sk_kades::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/surat-keputusan-kades')->with('success', 'Hapus Surat Keputusan Kepala Desa berhasil dilakukan!');
    }

    public function downloadSkKades(Request $request)
    {
        
        $surat  = $this->getDataSkKades($request, "ASC")->get();        

        $bulan  = $request->input('bulan') == "" ? "Semua" : $request->input('jenis');
        $tahun  = $request->input('tahun') == "" ? "Semua" : $request->input('tahun');

        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/format_surat/dokumen_desa/sk_kades.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A1')->setValue("AGENDA SURAT KEPUTUSAN KEPALA DESA " . strtoupper(option()->desa->name));
        // $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        // $worksheet->getCell('C4')->setValue(": " . $jenis);
        // $worksheet->getCell('C5')->setValue(": " . $tahun);

        // die(json_encode($surat));
        $batas = 5;
        if (sizeof($surat) > 0) {
            $baris  = $batas;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->no_kades);                
                $worksheet->getCell('C' . $baris)->setValue($item->tgl_kades); 
                $worksheet->getCell('D' . $baris)->setValue($item->tentang);
                $worksheet->getCell('E' . $baris)->setValue($item->uraian);
                $worksheet->getCell('F' . $baris)->setValue($item->no_diundangkan);                
                $worksheet->getCell('G' . $baris)->setValue($item->tgl_diundangkan);  
                $worksheet->getCell('H' . $baris)->setValue($item->keterangan);
                $baris++;
                $no++;
            }
        } else {
            $worksheet->mergeCells('A' . $batas . ':E' . $batas);
            $worksheet->getCell('A' . $batas)->setValue('Data Tidak Ditemukan!');
        }

        $worksheet->getStyle('A3:H' . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "AGENDA_SK_KADES_" . $bulan . "_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    //BPD ================================================================
    public function getDataSkBpd(Request $request, $order = "DESC")
    {
        $sk  = Sk_bpd::orderBy('created_at', $order);
        if (
            $request->input('q') != null ||
            $request->input('bulan') != null ||
            $request->input('tahun') != null
        ) {
            $q      = $request->input('q');
            $bulan  = $request->input('bulan');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $sk->where(function ($query) use ($q) {
                    $query->where('nomor', 'LIKE', "%$q%")
                        ->orWhere('tanggal', 'LIKE', "%$q%")
                        ->orWhere('tentang', 'LIKE', "%$q%")
                        ->orWhere('uraian', 'LIKE', "%$q%")                        
                        ->orWhere('keterangan', 'LIKE', "%$q%");
                });
            }

            if ($bulan != "" && $bulan != "semua") {
                $sk->where(function ($query2) use ($bulan) {
                    $query2->whereMonth("created_at", "=", $bulan);
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $sk->where(function ($query3) use ($tahun) {
                    $query3->whereYear("created_at", "=", $tahun);
                });
            }
        }
        return $sk;
    }

    public function getSkBpd(Request $request)
    {
        $sk = $this->getDataSkBpd($request);
        $sk = $sk->paginate(50);
        $tahun  = Sk_bpd::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $ket    = [
            "q"     => $request->input('q'),
            "bulan" => $request->input('bulan'),
            "tahun" => $request->input('tahun')
        ];
        return view('dokumen_desa.sk_bpd', compact(
            'sk',
            'tahun',
            'ket'
        ));
    }

    public function addSkBpd(Request $request)
    {
        Sk_bpd::create([
            "nomor"         => $request->input('nomor'),
            "tanggal"       => $request->input('tanggal'),
            "tentang"       => $request->input('tentang'),
            "uraian"        => $request->input('uraian'),            
            "keterangan"    => $request->input('keterangan')
        ]);
        return redirect('/surat-keputusan-bpd')->with('success', 'Penambahan Surat Keputusan BPD
        berhasil dilakukan!');
    }

    public function editSkBpd(Request $request)
    {
        $surat = Sk_bpd::where('id', $request->input("id_sk"))->firstOrFail();
        $surat->update([
            "nomor"         => $request->input('nomor'),
            "tanggal"       => $request->input('tanggal'),
            "tentang"       => $request->input('tentang'),
            "uraian"        => $request->input('uraian'),            
            "keterangan"    => $request->input('keterangan')
        ]);
        return redirect('/surat-keputusan-bpd')->with('success', 'Edit Surat Keputusan BPD
        berhasil dilakukan!');
    }

    public function hapusSkBpd(Request $request)
    {
        $surat = Sk_bpd::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/surat-keputusan-bpd')->with('success', 'Hapus Surat Keputusan BPD berhasil dilakukan!');
    }

    public function downloadSkBpd(Request $request)
    {
        
        $surat  = $this->getDataSkBpd($request, "ASC")->get();        

        $bulan  = $request->input('bulan') == "" ? "Semua" : $request->input('jenis');
        $tahun  = $request->input('tahun') == "" ? "Semua" : $request->input('tahun');

        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/format_surat/dokumen_desa/sk_bpd.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A1')->setValue("AGENDA SURAT KEPUTUSAN BPD " . strtoupper(option()->desa->name));
        // $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        // $worksheet->getCell('C4')->setValue(": " . $jenis);
        // $worksheet->getCell('C5')->setValue(": " . $tahun);

        // die(json_encode($surat));
        $batas = 5;
        if (sizeof($surat) > 0) {
            $baris  = $batas;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->nomor);                
                $worksheet->getCell('C' . $baris)->setValue($item->tanggal);
                $worksheet->getCell('D' . $baris)->setValue($item->tentang);
                $worksheet->getCell('E' . $baris)->setValue($item->uraian);
                $worksheet->getCell('F' . $baris)->setValue($item->keterangan);                                
                $baris++;
                $no++;
            }
        } else {
            $worksheet->mergeCells('A' . $batas . ':F' . $batas);
            $worksheet->getCell('A' . $batas)->setValue('Data Tidak Ditemukan!');
        }
        ;
        $worksheet->getStyle('A3:' . $worksheet->getHighestColumn() . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "AGENDA_SK_BPD_" . $bulan . "_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    //PERDES ==============================================================
    public function getDataPerdes(Request $request, $order = "DESC")
    {
        $sk  = Perdes::orderBy('created_at', $order);
        if (
            $request->input('q') != null ||
            $request->input('bulan') != null ||
            $request->input('tahun') != null
        ) {
            $q      = $request->input('q');
            $bulan  = $request->input('bulan');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $sk->where(function ($query) use ($q) {
                    $query
                        ->where('no_perdes', 'LIKE', "%$q%")
                        ->orWhere('tgl_perdes', 'LIKE', "%$q%")
                        ->orWhere('tentang', 'LIKE', "%$q%")
                        ->orWhere('uraian', 'LIKE', "%$q%")    
                        ->where('no_persetujuan', 'LIKE', "%$q%")
                        ->orWhere('tgl_persetujuan', 'LIKE', "%$q%")
                        ->where('no_dilaporkan', 'LIKE', "%$q%")
                        ->orWhere('tgl_dilaporkan', 'LIKE', "%$q%")                    
                        ->orWhere('keterangan', 'LIKE', "%$q%");
                });
            }

            if ($bulan != "" && $bulan != "semua") {
                $sk->where(function ($query2) use ($bulan) {
                    $query2->whereMonth("created_at", "=", $bulan);
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $sk->where(function ($query3) use ($tahun) {
                    $query3->whereYear("created_at", "=", $tahun);
                });
            }
        }
        return $sk;
    }

    public function getPerdes(Request $request)
    {
        $sk = $this->getDataPerdes($request);
        $sk = $sk->paginate(50);
        $tahun  = Perdes::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $ket    = [
            "q"     => $request->input('q'),
            "bulan" => $request->input('bulan'),
            "tahun" => $request->input('tahun')
        ];
        return view('dokumen_desa.perdes', compact(
            'sk',
            'tahun',
            'ket'
        ));
    }

    public function addPerdes(Request $request)
    {        
        Perdes::create([
            "no_perdes"             => $request->input('no_perdes'),
            "tgl_perdes"            => $request->input('tgl_perdes'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_persetujuan"        => $request->input('no_persetujuan'),
            "tgl_persetujuan"       => $request->input('tgl_persetujuan'),         
            "no_dilaporkan"         => $request->input('no_dilaporkan'),
            "tgl_dilaporkan"        => $request->input('tgl_dilaporkan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/perdes')->with('success', 'Penambahan Peraturan Desa
        berhasil dilakukan!');
    }

    public function editPerdes(Request $request)
    {
        $surat = Perdes::where('id', $request->input("id_sk"))->firstOrFail();
        $surat->update([
            "no_perdes"             => $request->input('no_perdes'),
            "tgl_perdes"            => $request->input('tgl_perdes'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_persetujuan"        => $request->input('no_persetujuan'),
            "tgl_persetujuan"       => $request->input('tgl_persetujuan'),         
            "no_dilaporkan"         => $request->input('no_dilaporkan'),
            "tgl_dilaporkan"        => $request->input('tgl_dilaporkan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/perdes')->with('success', 'Edit Peraturan Desa
        berhasil dilakukan!');
    }

    public function hapusPerdes(Request $request)
    {
        $surat = Perdes::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/perdes')->with('success', 'Hapus Peraturan Desa berhasil dilakukan!');
    }

    public function downloadPerdes(Request $request)
    {
        
        $surat  = $this->getDataPerdes($request, "ASC")->get();        

        $bulan  = $request->input('bulan') == "" ? "Semua" : $request->input('jenis');
        $tahun  = $request->input('tahun') == "" ? "Semua" : $request->input('tahun');

        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/format_surat/dokumen_desa/perdes.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A1')->setValue("AGENDA PERATURAN DESA " . strtoupper(option()->desa->name));
        // $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        // $worksheet->getCell('C4')->setValue(": " . $jenis);
        // $worksheet->getCell('C5')->setValue(": " . $tahun);

        // die(json_encode($surat));

        $batas = 5;
        if (sizeof($surat) > 0) {
            $baris  = $batas;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->no_perdes);                
                $worksheet->getCell('C' . $baris)->setValue($item->tgl_perdes);
                $worksheet->getCell('D' . $baris)->setValue($item->tentang);
                $worksheet->getCell('E' . $baris)->setValue($item->uraian);
                $worksheet->getCell('F' . $baris)->setValue($item->no_persetujuan);                                
                $worksheet->getCell('G' . $baris)->setValue($item->tgl_persetujuan);
                $worksheet->getCell('H' . $baris)->setValue($item->no_dilaporkan);
                $worksheet->getCell('I' . $baris)->setValue($item->tgl_dilaporkan);
                $worksheet->getCell('J' . $baris)->setValue($item->keterangan);
                $baris++;
                $no++;
            }
        } else {
            $worksheet->mergeCells('A' . $batas . ':F' . $batas);
            $worksheet->getCell('A' . $batas)->setValue('Data Tidak Ditemukan!');
        }
        ;
        $worksheet->getStyle('A3:' . $worksheet->getHighestColumn() . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "AGENDA_PERDES_" . $bulan . "_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    //PERKADES ==============================================================
    public function getDataPerkades(Request $request, $order = "DESC")
    {
        $sk  = Perkades::orderBy('created_at', $order);
        if (
            $request->input('q') != null ||
            $request->input('bulan') != null ||
            $request->input('tahun') != null
        ) {
            $q      = $request->input('q');
            $bulan  = $request->input('bulan');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $sk->where(function ($query) use ($q) {
                    $query
                        ->where('no_perkades', 'LIKE', "%$q%")
                        ->orWhere('tgl_perkades', 'LIKE', "%$q%")
                        ->orWhere('tentang', 'LIKE', "%$q%")
                        ->orWhere('uraian', 'LIKE', "%$q%")    
                        ->where('no_pengundangan', 'LIKE', "%$q%")
                        ->orWhere('tgl_pengundangan', 'LIKE', "%$q%")                 
                        ->orWhere('keterangan', 'LIKE', "%$q%");
                });
            }

            if ($bulan != "" && $bulan != "semua") {
                $sk->where(function ($query2) use ($bulan) {
                    $query2->whereMonth("created_at", "=", $bulan);
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $sk->where(function ($query3) use ($tahun) {
                    $query3->whereYear("created_at", "=", $tahun);
                });
            }
        }
        return $sk;
    }

    public function getPerkades(Request $request)
    {
        $sk = $this->getDataPerkades($request);
        $sk = $sk->paginate(50);
        $tahun  = Perkades::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $ket    = [
            "q"     => $request->input('q'),
            "bulan" => $request->input('bulan'),
            "tahun" => $request->input('tahun')
        ];
        return view('dokumen_desa.perkades', compact(
            'sk',
            'tahun',
            'ket'
        ));
    }

    public function addPerkades(Request $request)
    {      
        Perkades::create([
            "no_perkades"           => $request->input('no_perkades'),
            "tgl_perkades"          => $request->input('tgl_perkades'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_pengundangan"       => $request->input('no_pengundangan'),
            "tgl_pengundangan"      => $request->input('tgl_pengundangan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/perkades')->with('success', 'Penambahan Peraturan Kepala Desa
        berhasil dilakukan!');
    }

    public function editPerkades(Request $request)
    {
        $surat = Perkades::where('id', $request->input("id_sk"))->firstOrFail();
        $surat->update([
            "no_perkades"           => $request->input('no_perkades'),
            "tgl_perkades"          => $request->input('tgl_perkades'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_pengundangan"       => $request->input('no_pengundangan'),
            "tgl_pengundangan"      => $request->input('tgl_pengundangan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/perkades')->with('success', 'Edit Peraturan Kepala Desa
        berhasil dilakukan!');
    }

    public function hapusPerkades(Request $request)
    {
        $surat = Perkades::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/perkades')->with('success', 'Hapus Peraturan Kepala Desa berhasil dilakukan!');
    }

    public function downloadPerkades(Request $request)
    {
        
        $surat  = $this->getDataPerkades($request, "ASC")->get();        

        $bulan  = $request->input('bulan') == "" ? "Semua" : $request->input('jenis');
        $tahun  = $request->input('tahun') == "" ? "Semua" : $request->input('tahun');

        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/format_surat/dokumen_desa/perkades.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A1')->setValue("AGENDA PERATURAN KEPALA DESA " . strtoupper(option()->desa->name));
        // $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        // $worksheet->getCell('C4')->setValue(": " . $jenis);
        // $worksheet->getCell('C5')->setValue(": " . $tahun);

        // die(json_encode($surat));

        $batas = 5;
        if (sizeof($surat) > 0) {
            $baris  = $batas;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->no_perkades);                
                $worksheet->getCell('C' . $baris)->setValue($item->tgl_perkades);
                $worksheet->getCell('D' . $baris)->setValue($item->tentang);
                $worksheet->getCell('E' . $baris)->setValue($item->uraian);
                $worksheet->getCell('F' . $baris)->setValue($item->no_pengundangan);                                
                $worksheet->getCell('G' . $baris)->setValue($item->tgl_pengundangan);
                $worksheet->getCell('H' . $baris)->setValue($item->keterangan);
                $baris++;
                $no++;
            }
        } else {
            $worksheet->mergeCells('A' . $batas . ':' . $worksheet->getHighestColumn() . $batas);
            $worksheet->getCell('A' . $batas)->setValue('Data Tidak Ditemukan!');
        }
        ;
        $worksheet->getStyle('A3:' . $worksheet->getHighestColumn() . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "AGENDA_PERKADES_" . $bulan . "_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    //Pengundangan Perdes===============================================
    public function getDataPengundanganPerdes(Request $request, $order = "DESC")
    {
        $sk  = Pengundangan_perdes::orderBy('created_at', $order);
        if (
            $request->input('q') != null ||
            $request->input('bulan') != null ||
            $request->input('tahun') != null
        ) {
            $q      = $request->input('q');
            $bulan  = $request->input('bulan');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $sk->where(function ($query) use ($q) {
                    $query
                        ->where('no_perdes', 'LIKE', "%$q%")
                        ->orWhere('tgl_perdes', 'LIKE', "%$q%")
                        ->orWhere('tentang', 'LIKE', "%$q%")
                        ->orWhere('uraian', 'LIKE', "%$q%")    
                        ->where('no_pengundangan', 'LIKE', "%$q%")
                        ->orWhere('tgl_pengundangan', 'LIKE', "%$q%")                 
                        ->orWhere('keterangan', 'LIKE', "%$q%");
                });
            }

            if ($bulan != "" && $bulan != "semua") {
                $sk->where(function ($query2) use ($bulan) {
                    $query2->whereMonth("created_at", "=", $bulan);
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $sk->where(function ($query3) use ($tahun) {
                    $query3->whereYear("created_at", "=", $tahun);
                });
            }
        }
        return $sk;
    }

    public function getPengundanganPerdes(Request $request)
    {
        $sk = $this->getDataPengundanganPerdes($request);
        $sk = $sk->paginate(50);
        $tahun  = Pengundangan_perdes::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $ket    = [
            "q"     => $request->input('q'),
            "bulan" => $request->input('bulan'),
            "tahun" => $request->input('tahun')
        ];
        return view('dokumen_desa.pengundangan_perdes', compact(
            'sk',
            'tahun',
            'ket'
        ));
    }

    public function addPengundanganPerdes(Request $request)
    {              
        Pengundangan_perdes::create([
            "no_perdes"             => $request->input('no_perdes'),
            "tgl_perdes"            => $request->input('tgl_perdes'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_pengundangan"       => $request->input('no_pengundangan'),
            "tgl_pengundangan"      => $request->input('tgl_pengundangan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/pengundangan-perdes')->with('success', 'Penambahan Pengundangan Peraturan Desa
        berhasil dilakukan!');
    }

    public function editPengundanganPerdes(Request $request)
    {
        $surat = Pengundangan_perdes::where('id', $request->input("id_sk"))->firstOrFail();
        $surat->update([
            "no_perdes"             => $request->input('no_perdes'),
            "tgl_perdes"            => $request->input('tgl_perdes'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_pengundangan"       => $request->input('no_pengundangan'),
            "tgl_pengundangan"      => $request->input('tgl_pengundangan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/pengundangan-perdes')->with('success', 'Edit Pengundangan Peraturan Desa
        berhasil dilakukan!');
    }

    public function hapusPengundanganPerdes(Request $request)
    {
        $surat = Pengundangan_perdes::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/pengundangan-perdes')->with('success', 'Hapus Pengundangan Peraturan Desa berhasil dilakukan!');
    }

    public function downloadPengundanganPerdes(Request $request)
    {
        
        $surat  = $this->getDataPengundanganPerdes($request, "ASC")->get();        

        $bulan  = $request->input('bulan') == "" ? "Semua" : $request->input('jenis');
        $tahun  = $request->input('tahun') == "" ? "Semua" : $request->input('tahun');

        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/format_surat/dokumen_desa/pengundangan_perdes.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A1')->setValue("AGENDA PENGUNDANGAN PERATURAN DESA " . strtoupper(option()->desa->name));
        // $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        // $worksheet->getCell('C4')->setValue(": " . $jenis);
        // $worksheet->getCell('C5')->setValue(": " . $tahun);

        // die(json_encode($surat));        

        $batas = 5;
        if (sizeof($surat) > 0) {
            $baris  = $batas;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->no_perdes);                
                $worksheet->getCell('C' . $baris)->setValue($item->tgl_perdes);
                $worksheet->getCell('D' . $baris)->setValue($item->tentang);
                $worksheet->getCell('E' . $baris)->setValue($item->uraian);
                $worksheet->getCell('F' . $baris)->setValue($item->no_pengundangan);                                
                $worksheet->getCell('G' . $baris)->setValue($item->tgl_pengundangan);
                $worksheet->getCell('H' . $baris)->setValue($item->keterangan);
                $baris++;
                $no++;
            }
        } else {
            $worksheet->mergeCells('A' . $batas . ':' . $worksheet->getHighestColumn() . $batas);
            $worksheet->getCell('A' . $batas)->setValue('Data Tidak Ditemukan!');
        }
        ;
        $worksheet->getStyle('A3:' . $worksheet->getHighestColumn() . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "AGENDA_PENGUNDANGAN_PERDES_" . $bulan . "_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    //Pengundangan Perkades===============================================
    public function getDataPengundanganPerkades(Request $request, $order = "DESC")
    {
        $sk  = Pengundangan_perkades::orderBy('created_at', $order);
        if (
            $request->input('q') != null ||
            $request->input('bulan') != null ||
            $request->input('tahun') != null
        ) {
            $q      = $request->input('q');
            $bulan  = $request->input('bulan');
            $tahun  = $request->input('tahun');

            if ($q != "") {
                $sk->where(function ($query) use ($q) {
                    $query
                        ->where('no_perkades', 'LIKE', "%$q%")
                        ->orWhere('tgl_perkades', 'LIKE', "%$q%")
                        ->orWhere('tentang', 'LIKE', "%$q%")
                        ->orWhere('uraian', 'LIKE', "%$q%")    
                        ->where('no_pengundangan', 'LIKE', "%$q%")
                        ->orWhere('tgl_pengundangan', 'LIKE', "%$q%")                 
                        ->orWhere('keterangan', 'LIKE', "%$q%");
                });
            }

            if ($bulan != "" && $bulan != "semua") {
                $sk->where(function ($query2) use ($bulan) {
                    $query2->whereMonth("created_at", "=", $bulan);
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $sk->where(function ($query3) use ($tahun) {
                    $query3->whereYear("created_at", "=", $tahun);
                });
            }
        }
        return $sk;
    }

    public function getPengundanganPerkades(Request $request)
    {
        $sk = $this->getDataPengundanganPerkades($request);
        $sk = $sk->paginate(50);
        $tahun  = Pengundangan_perkades::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $ket    = [
            "q"     => $request->input('q'),
            "bulan" => $request->input('bulan'),
            "tahun" => $request->input('tahun')
        ];
        return view('dokumen_desa.pengundangan_perkades', compact(
            'sk',
            'tahun',
            'ket'
        ));
    }

    public function addPengundanganPerkades(Request $request)
    {              
        Pengundangan_perkades::create([
            "no_perkades"           => $request->input('no_perkades'),
            "tgl_perkades"          => $request->input('tgl_perkades'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_pengundangan"       => $request->input('no_pengundangan'),
            "tgl_pengundangan"      => $request->input('tgl_pengundangan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/pengundangan-perkades')->with('success', 'Penambahan Pengundangan Peraturan Kepala Desa
        berhasil dilakukan!');
    }

    public function editPengundanganPerkades(Request $request)
    {
        $surat = Pengundangan_perkades::where('id', $request->input("id_sk"))->firstOrFail();
        $surat->update([
            "no_perkades"           => $request->input('no_perkades'),
            "tgl_perkades"          => $request->input('tgl_perkades'),
            "tentang"               => $request->input('tentang'),
            "uraian"                => $request->input('uraian'),   
            "no_pengundangan"       => $request->input('no_pengundangan'),
            "tgl_pengundangan"      => $request->input('tgl_pengundangan'), 
            "keterangan"            => $request->input('keterangan')
        ]);
        return redirect('/pengundangan-perkades')->with('success', 'Edit Pengundangan Peraturan Kepala Desa
        berhasil dilakukan!');
    }

    public function hapusPengundanganPerkades(Request $request)
    {
        $surat = Pengundangan_perkades::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/pengundangan-perkades')->with('success', 'Hapus Pengundangan Peraturan Kepala Desa berhasil dilakukan!');
    }

    public function downloadPengundanganPerkades(Request $request)
    {
        
        $surat  = $this->getDataPengundanganPerkades($request, "ASC")->get();        

        $bulan  = $request->input('bulan') == "" ? "Semua" : $request->input('jenis');
        $tahun  = $request->input('tahun') == "" ? "Semua" : $request->input('tahun');

        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/format_surat/dokumen_desa/pengundangan_perkades.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A1')->setValue("AGENDA PENGUNDANGAN PERATURAN KEPALA DESA " . strtoupper(option()->desa->name));
        // $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        // $worksheet->getCell('C4')->setValue(": " . $jenis);
        // $worksheet->getCell('C5')->setValue(": " . $tahun);

        // die(json_encode($surat));        

        $batas = 5;
        if (sizeof($surat) > 0) {
            $baris  = $batas;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->no_perkades);                
                $worksheet->getCell('C' . $baris)->setValue($item->tgl_perkades);
                $worksheet->getCell('D' . $baris)->setValue($item->tentang);
                $worksheet->getCell('E' . $baris)->setValue($item->uraian);
                $worksheet->getCell('F' . $baris)->setValue($item->no_pengundangan);                                
                $worksheet->getCell('G' . $baris)->setValue($item->tgl_pengundangan);
                $worksheet->getCell('H' . $baris)->setValue($item->keterangan);
                $baris++;
                $no++;
            }
        } else {
            $worksheet->mergeCells('A' . $batas . ':' . $worksheet->getHighestColumn() . $batas);
            $worksheet->getCell('A' . $batas)->setValue('Data Tidak Ditemukan!');
        }
        ;
        $worksheet->getStyle('A3:' . $worksheet->getHighestColumn() . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "AGENDA_PENGUNDANGAN_PERKADES_" . $bulan . "_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
