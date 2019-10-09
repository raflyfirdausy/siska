<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\General\Official;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::all();

        return view('umum.perangkat-desa.index', compact('officials'));
    }

    public function store(Request $request)
    {
        die($request->photo->hashName());
        $request->validate([
            'nip' => 'required',
            'name' => 'required',
            'photo' => 'nullable',
            'position' => 'required|in:kepala_desa,sekretaris_desa,kaur_pemerintahan,kaur_umum,kaur_keuangan,kaur_pembangunan,kaur_keamanan_dan_ketertiban',
        ]);

        $photoName = $request->photo->hashName();
        
        $url = $request->photo->storeAs('uploaded/images', $photoName, 'public');
        $official = new Official($request->except('photo'));
        $official->photo = $url;
        $official->save();
        return redirect('perangkat-desa')->with('success', 'Penambahan perangkat desa berhasil dilakukan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required',
            'name' => 'required',
            'photo' => 'nullable',
            'position' => 'required|in:kepala_desa,sekretaris_desa,kaur_pemerintahan,kaur_umum,kaur_keuangan,kaur_pembangunan,kaur_keamanan_dan_ketertiban',
        ]);

        $official = Official::findOrFail($id);

        if ($request->hasFile('photo')) { 
            Storage::disk('public')->delete($official->photo);
            $photoName = $request->photo->hashName();
            $url = $request->photo->storeAs('uploaded/images', $photoName, 'public');
            $official->photo = $url;
        }

        $official->fill($request->except('photo'));
        $official->save();

        return redirect('perangkat-desa')->with('success', 'Pengubahan perangkat desa berhasil dilakukan!');
    }

    public function destroy($id)
    {
        $official = Official::findOrFail($id);
        Storage::disk('public')->delete($official->photo);
        $official->delete();

        return redirect('perangkat-desa')->with('success', 'Penghapusan perangkat desa berhasil dilakukan!');
    }
}