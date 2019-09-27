<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Territory;

class TerritoryController extends Controller
{
    public function getProvinces()
    {
        return Territory::where('id', 'LIKE', '__')->get();
    }

    public function getTerritories($id)
    {
        return Territory::where('id', 'LIKE', $id . '.__')->get();
    }

    public function getVillages($id)
    {
        return Territory::where('id', 'LIKE', $id . '.____')->get();
    }
}
