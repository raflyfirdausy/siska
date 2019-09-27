<?php

namespace App\Models\Estate;

use Illuminate\Database\Eloquent\Model;

class LandOwner extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function resident() {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function certificate() {
        return $this->belongsTo('App\Models\Estate\LandCertificate');
    }
}
