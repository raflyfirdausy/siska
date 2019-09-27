<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function provinsi()
    {
        return $this->hasOne('App\Models\Territory', 'id', 'province');
    }

    public function kabupaten()
    {
        return $this->hasOne('App\Models\Territory', 'id', 'district');
    }
    
    public function kecamatan()
    {
        return $this->hasOne('App\Models\Territory', 'id', 'sub_district');
    }
    
    public function desa()
    {
        return $this->hasOne('App\Models\Territory', 'id', 'village');
    }
}
