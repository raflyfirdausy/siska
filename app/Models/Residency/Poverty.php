<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class Poverty extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }
}
