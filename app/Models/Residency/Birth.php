<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class Birth extends Model
{
    public $timestamps = false;

    protected $dates = ['date_of_birth'];

    protected $guarded = ['id'];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function father()
    {
        return $this->belongsTo('App\Models\Residency\Resident', 'father_id');
    }

    public function mother()
    {
        return $this->belongsTo('App\Models\Residency\Resident', 'mother_id');
    }

    public function family()
    {
        return $this->belongsTo('App\Models\Residency\Family', 'family_id');
    }

    public function getFamilyMemberAttribute()
    {
        return $this->family->members()->where('resident_id', $this->resident_id)->first();
    }

    public function getTempatBersalinAttribute()
    {
        $place = $this->attributes['labor_place'];
        $place = explode('_', $place);
        for ($i = 0; $i < count($place); $i++) {
            $place[$i] = ucfirst($place[$i]);
        }

        return implode(' ', $place);
    }

    public function getPembantuPersalinanAttribute()
    {
        return ucfirst($this->attributes['labor_helper']);
    }
    
    public function getHubunganPelaporAttribute()
    {
        return ucfirst($this->attributes['reporter_relation']);
    }
}
