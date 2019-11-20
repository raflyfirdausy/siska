<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Residency\Resident;
use App\Models\Residency\Family;
use App\Models\Residency\Poverty;
use App\Models\Secretariat\Mail;
use App\Models\Residency\Birth;
use App\Models\Residency\Death;
use App\Models\Residency\Transfer;
use App\Models\Residency\Newcomer;
use App\Models\Residency\LaborMigration;
use App\Models\Surat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HomeController extends Controller
{
    public function index() {
        $totalMails = Surat::all()->count();
        $inboxCount = Surat::where('jenis', 'masuk')->get()->count();
        $outboxCount = Surat::where('jenis', 'keluar')->get()->count();

        $jumlahJiwa = array(
            array(
                "label" => "Pria",
                "value" => 1627
            ),
            array(
                "label" => "Wanita",
                "value" => 1691
            )
        );

        $jumlahKepalaKeluarga = array(
            array(
                "label" => "Pria",
                "value" => 875
            ),
            array(
                "label" => "Wanita",
                "value" => 208
            )
        );

        $jumlahKepemilikanKartuKeluarga = array(
            array(
                "label" => "Pria",
                "value" => 862
            ),
            array(
                "label" => "Wanita",
                "value" => 188
            )
        );

        return view('dashboard', compact(            
            'totalMails',
            'inboxCount',
            'outboxCount',
            'jumlahJiwa',
            'jumlahKepalaKeluarga',
            'jumlahKepemilikanKartuKeluarga'
        ));
    }

    public function downloadStatistik(){        
        $inputFileType  = 'Xlsx';
        $inputFileName  = "public/statistik/statistik.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);               

        $writer = new Xlsx($spreadsheet);
        $filename = "STATISTIK_DESA_WANADADI_SEMESTER_1_2019_DOWNLOADED_" . date("d_m_Y_H_i_s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function login() {
        return view('login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        
        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect('/dashboard');
        }
        
        return redirect('/login')->withErrors(['login' => 'Username atau Password Anda salah!']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
