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

class HomeController extends Controller
{
    public function index() {
        $familiesCount = Family::all()->count();
        $residentsCount = Resident::canBeDisplayed()->get()->count();
        $genders = collect([
            'male', 'female',
        ])->map(function($item) {
            $count = Resident::where('gender', $item)->canBeDisplayed()->count();
            return $count;
        });

        $malesCount = $genders[0];
        $femalesCount = $genders[1];

        $totalMails = Mail::all()->count();
        $inboxCount = Mail::where('type', 'in')->get()->count();
        $outboxCount = Mail::where('type', 'out')->get()->count();

        $povertiesCount = Poverty::all()->count();

        $birthsCount = Birth::all()->count();
        $deathsCount = Death::all()->count();
        $newcomersCount = Newcomer::all()->count();
        $migrationsCount = LaborMigration::all()->count();
        $transfersCount = Transfer::all()->count();

        return view('dashboard', compact(
            'familiesCount',
            'residentsCount',
            'malesCount',
            'femalesCount',
            'povertiesCount',
            'totalMails',
            'inboxCount',
            'outboxCount',
            'birthsCount',
            'deathsCount',
            'newcomersCount',
            'migrationsCount',
            'transfersCount'
        ));
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
