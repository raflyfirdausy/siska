<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    public $timestamps = false;

    public function residents()
    {
        return $this->hasMany('App\Models\Residency\Resident');
    }
}
