<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function GuzzleHttp\json_encode;

class SuratController extends Controller
{

    public function cekKodeSuratLengkap(Request $request){
        $nomer_surat = $request->input('no_surat');
        $count = Surat::whereRaw('REPLACE(nomer, " ", "") = REPLACE(?, " ", "")', [$nomer_surat])->count();
        return response()->json([
            "count" => $count
        ]);      
    }

    public function getDataSuratKeluar(Request $request, $order = "DESC")
    {
        $surat  = Surat::orderBy('created_at', $order)->where('jenis', 'keluar');
        if (
            $request->input('q') != "" ||
            $request->input('tahun') != "" ||
            $request->input('jenis') != ""
        ) {
            $q      = $request->input('q');
            $tahun  = $request->input('tahun');
            $jenis  = $request->input('jenis');

            if ($q != "") {
                $surat->where(function ($query) use ($q) {
                    $query->where('nomer', 'LIKE', "%$q%")
                        ->orWhere('tanggal', 'LIKE', "%$q%")
                        ->orWhere('perihal', 'LIKE', "%$q%")
                        ->orWhere('dari', 'LIKE', "%$q%")
                        ->orWhere('type', 'LIKE', "%$q%")
                        ->orWhere('jenis', 'LIKE', "%$q%")
                        ->orWhere('nik', 'LIKE', "%$q%");
                });
            }

            if ($tahun != "" && $tahun != "semua") {
                $surat->where(function ($query2) use ($tahun) {
                    $query2->whereYear("tanggal", "=", $tahun);
                });
            }

            if ($jenis != "" && $jenis != "semua") {
                $surat->where(function ($query2) use ($jenis) {
                    $query2->where("type", "=", $jenis);
                });
            }
        }
        return $surat;
    }

    public function getSuratKeluar(Request $request)
    {
        $surat  = $this->getDataSuratKeluar($request);
        $surat  = $surat->paginate(10);
        $jenis  = Surat::distinct()->get(["type"]);
        $tahun  = Surat::select(DB::raw('YEAR(created_at) as tahun'))->distinct()->get();
        $type   = "Keluar";
        $ket    = [
            "q"     => $request->input('q'),
            "tahun" => $request->input('tahun'),
            "jenis" => $request->input('jenis')
        ];
        return view('kesekretariatan.surat.index2', compact('surat', 'jenis', 'tahun', 'type', 'ket'));
    }

    public function addSuratKeluarManual(Request $request)
    {
        Surat::create([
            "nomer"     => $request->input('no_surat'),
            "tanggal"   => $request->input('tanggal_surat'),
            "type"      => $request->input('jenis_surat'),
            "dari"      => "Ds. " . ucfirst(strtolower(option()->desa->name)),
            "perihal"   => $request->input('perihal'),
            "jenis"     => "keluar",
            "nik"       => NULL
        ]);
        return redirect('/surat-keluar')->with('success', 'Penambahan surat keluar baru berhasil dilakukan!');
    }

    public function editSuratKeluar (Request $request)
    {
        $surat = Surat::where('id', $request->input("id_surat"))->firstOrFail();
        $surat->update([
            "nomer"     => $request->input('no_surat'),
            "tanggal"   => $request->input('tanggal_surat'),
            "type"      => $request->input('jenis_surat'),            
            "perihal"   => $request->input('perihal')
        ]);
        return redirect('/surat-keluar')->with('success', 'Edit surat keluar berhasil dilakukan!');
    }

    public function hapusSuratKeluar(Request $request){
        $surat = Surat::where('id', $request->input("hapus_id"))->firstOrFail();
        $surat->delete();
        return redirect('/surat-keluar')->with('success', 'Hapus surat keluar berhasil dilakukan!');
    }

    public function downloadSuratKeluar(Request $request)
    {
        $surat  = $this->getDataSuratKeluar($request, "ASC")->get();

        $jenis  = $request->input('jenis') == "" ? "Semua" : $request->input('jenis');
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
        $inputFileName  = "public/format_surat/agenda_surat_keluar.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        //SET DATA
        $worksheet->getCell('A2')->setValue("Desa " . option()->desa->name . ", Kecamatan " . option()->kecamatan->name);
        $worksheet->getCell('C4')->setValue(": " . $jenis);
        $worksheet->getCell('C5')->setValue(": " . $tahun);
        
        // die(json_encode($surat));
        if (sizeof($surat) > 0) {
            $baris  = 8;
            $no     = 1;
            foreach ($surat as $item) {
                $worksheet->getCell('A' . $baris)->setValue($no);
                $worksheet->getCell('B' . $baris)->setValue($item->nomer);
                $worksheet->getCell('C' . $baris)->setValue(date_indo($item->tanggal));
                $worksheet->getCell('D' . $baris)->setValue(ucwords(strtolower($item->perihal)));
                $worksheet->getCell('E' . $baris)->setValue(date_indo(date("Y-m-d", strtotime($item->created_at))));
                $baris++;
                $no++;
            }        
        } else {
            $worksheet->mergeCells('A8:E8');
            $worksheet->getCell('A8')->setValue('Data Tidak Ditemukan!');            
        }

        $worksheet->getStyle('A8:E' . $worksheet->getHighestRow())->applyFromArray($styleBorder);


        $writer = new Xlsx($spreadsheet);
        $filename = "BUKU_AGENDA_SURAT_KELUAR_" . strtoupper($jenis) . "_TH_" . $tahun . "_EXPORTED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
