<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\General\Option;
use App\Models\Territory;

class OptionController extends Controller
{
    public function index()
    {
        $option = Option::first();

        return view('umum.pengaturan.index', compact('option'));
    }

    public function edit()
    {
        $option = Option::first();

        $provinces = $provinces = Territory::where('id', 'LIKE', '__')->get();
        $listOfDistricts = Territory::where('id', 'LIKE', $option->province . '.__')->get();
        $listOfSubDistricts = Territory::where('id', 'LIKE', $option->district . '.__')->get();
        $listOfVillages = Territory::where('id', 'LIKE', $option->sub_district . '.____')->get();

        return view('umum.pengaturan.ubah', compact('option', 'provinces', 'listOfDistricts', 'listOfSubDistricts', 'listOfVillages'));
    }

    public function update(Request $request)
    {
        $option = Option::first();
        $option->update($request->except('logo', 'background_image'));

        if ($request->hasFile('background_image')) {
            if ($option->background_image) {
                Storage::disk('public')->delete($option->background_image);
            }
            $photoName = $request->background_image->hashName();
            $path = $request->background_image->storeAs('uploaded/images', $photoName, 'public');

            $option->background_image = $path;
        }

        if ($request->hasFile('logo')) {
            if ($option->logo) {
                Storage::disk('public')->delete($option->logo);
            }
            $photoName = $request->logo->hashName();
            $path = $request->logo->storeAs('uploaded/images', $photoName, 'public');

            $option->logo = $path;
        }

        $option->save();

        return redirect('pengaturan')->with('success', 'Perubahan pengaturan berhasil dilakukan!');
    }
}
