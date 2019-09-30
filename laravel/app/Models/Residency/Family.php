<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;
use App\Models\Territory;

class Family extends Model
{
    public $timestamps = false;

    protected $table = 'families';

    protected $guarded = ['id'];

    public function members()
    {
        return $this->hasMany('App\Models\Residency\FamilyMember');
    }

    public function familyHead()
    {
        $head = $this->members()->familyHead()->first();
        return $head ? $head->resident : $this->members()->first()->resident;
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

        return "{$address} RT:{$rt}/RW:{$rw}, {$villageName}, {$village}, {$subDistrict}, {$district}, {$province}";
    }

    public function getAlamatAttribute()
    {
        $address = $this->attributes['address'];
        $rt = $this->attributes['rt'];
        $rw = $this->attributes['rw'];
        $villageName = $this->attributes['village_name'];

        return "{$address} RT:{$rt}/RW:{$rw} {$villageName}";
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
