<?php

namespace App\Http\Controllers\Secretariat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Secretariat\Service;
use App\Models\Residency\Resident;

class ServiceController extends Controller
{
    public function index(Request $request) {
        $pelayanan = Service::with('resident');


        if ($request->has('q')) {
            $q = $request->input('q');
            $pelayanan = $pelayanan->whereHas('resident', function($query) use ($q) {
                return $query->where('nik', 'LIKE', '%'.$q.'%')
                    ->orWhere('name', 'LIKE', '%'.$q.'%');
            });
        }

        $pelayanan = $pelayanan->get();


        return view('pelayanan.masyarakat.index', compact('pelayanan'));
    }
    public function destroy($id) {
        $service = Service::findOrFail($id);
        $service->delete();
        
        return redirect("pendaftaran")->with('success', 'Penghapusan data masyarakat berhasil dilakukan!');
    }
    public function store(Request $request){

        $current = Carbon::now();

        $request->validate([
            'pin' => 'required',
            'nik' => 'required',
        ]);

        $resident = Resident::where('nik', $request->nik)->firstOrFail();

        Service::create([
            'pin' => $request->pin,
            'resident_id' => $resident->id,
            'date_created' => $current,
            'last_login' => $current,
        ]);
        
        return redirect("pendaftaran")->with('success', 'Penambahan data masyarakat berhasil dilakukan!');
    }
}
