<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class PovertyAudit extends Model
{
    protected $guarded = ['id'];
    
    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }
}
