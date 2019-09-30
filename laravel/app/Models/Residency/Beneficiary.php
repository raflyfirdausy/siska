<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Residency\BeneficiaryType', 'beneficiary_type_id');
    }
}
