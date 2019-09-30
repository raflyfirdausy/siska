<?php

namespace App\Models\Estate;

use Illuminate\Database\Eloquent\Model;

class LandCertificate extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function resident() {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function owners() {
        return $this->hasMany('App\Models\Estate\LandOwner');
    }

    public function getPemilikSebelumnyaAttribute()
    {
        $res = '';
        $owners = $this->owners;
        $count = $owners->count();
        for ($i = 0; $i < $count; $i++) {
            $res = $res . "{$this->owners[$i]->resident->name} ({$this->owners[$i]->year})";
            if ($i != $count - 1) {
                $res = $res . ', ';
            }
        }

        return $res;
    }
}
