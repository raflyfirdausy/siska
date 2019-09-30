<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;
use App\Models\Territory;

class Newcomer extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function getRegionsAttribute()
    {
        return collect([
            $this->provinsi->name,
            $this->kabupaten->name,
            $this->kecamatan->name,
            $this->desa->name,
        ]);
    }

    public function getAlamatLengkapAttribute()
    {
        $address = $this->attributes['address'];
        $rt = $this->attributes['rt'];
        $rw = $this->attributes['rw'];
        $villageName = $this->attributes['village_name'];
        $province = $this->provinsi->name;
        $district = $this->kabupaten->name;
        $subDistrict = $this->kecamatan->name;
        $village = $this->desa->name;

        return "{$address} RT:06{$rw}/RW:{$rw}, {$villageName}, {$village}, {$subDistrict}, {$district}, {$province}";
    }

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
