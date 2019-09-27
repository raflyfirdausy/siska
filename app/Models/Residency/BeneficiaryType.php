<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryType extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function beneficiary()
    {
        return $this->hasMany('App\Models\Residency\Beneficiary');
    }
}
