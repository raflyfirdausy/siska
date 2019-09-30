<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Resident extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $dates = ['birthday'];

    public function setBirthdayAttribute($birthday) {
        $this->attributes['birthday'] = Carbon::createFromFormat('Y-m-d', $birthday);
    }

    public function getJenkelAttribute() {
        return $this->attributes['gender'] == 'male' ? 'Laki - Laki' : 'Perempuan';
    }

    public function getGoldarAttribute() {
        return strtoupper($this->attributes['blood_type']);
    }

    public function getKewarganegaraanAttribute() {
        return $this->attributes['nationality'] == 'dwi' ? 'Dwikewarganegaraan' :  strtoupper($this->attributes['nationality']);
    }

    public function getAgamaAttribute() {
        return ucfirst($this->attributes['religion']);
    }

    public function getStatusKawinAttribute() {
        $status = $this->attributes['marriage_status'];
        $status = explode('_', $status);
        for ($i = 0; $i < count($status); $i++) {
            $status[$i] = ucfirst($status[$i]);
        }

        return implode(' ', $status);
    }

    public function getStatusKependudukanAttribute() {
        $status = $this->attributes['resident_status'];
        $status = explode('_', $status);
        for ($i = 0; $i < count($status); $i++) {
            $status[$i] = ucfirst($status[$i]);
        }

        return implode(' ', $status);
    }

    public function getFamilyAttribute() {
        return $this->family_member->family;
    }

    public function family_member()
    {
        return $this->hasOne('App\Models\Residency\FamilyMember');
    }

    public function birth()
    {
        return $this->hasOne('App\Models\Residency\Birth', 'resident_id');
    }

    public function father_of()
    {
        return $this->hasMany('App\Models\Residency\Birth', 'father_id');
    }

    public function mother_of()
    {
        return $this->hasMany('App\Models\Residency\Birth', 'mother_id');
    }

    public function death()
    {
        return $this->hasOne('App\Models\Residency\Death');
    }

    public function transfer()
    {
        return $this->hasOne('App\Models\Residency\Transfer');
    }

    public function migration()
    {
        return $this->hasOne('App\Models\Residency\LaborMigration');
    }

    public function education()
    {
        return $this->belongsTo('App\Models\Residency\Education');
    }

    public function occupation()
    {
        return $this->belongsTo('App\Models\Residency\Occupation');
    }

    public function poverty_audits()
    {
        return $this->hasMany('App\Models\Residency\PovertyAudit');
    }

    public function poverty()
    {
        return $this->hasOne('App\Models\Residency\Poverty');
    }

    public function beneficiary()
    {
        return $this->hasOne('App\Models\Residency\Beneficiary', 'resident_id');
    }

    public function newcomer()
    {
        return $this->hasOne('App\Models\Residency\Newcomer', 'resident_id');
    }

    public function land_certificates()
    {
        return $this->hasMany('App\Models\Estate\LandCertificate', 'resident_id');
    }

    public function lands_owned()
    {
        return $this->hasMany('App\Models\Estate\LandOwner', 'resident_id');
    }

    public function scopeIsNotBeneficiary($q)
    {
        return $q->doesntHave('beneficiary');
    }

    public function scopeHasNotDead($q)
    {
        return $q->doesntHave('death');
    }

    public function scopeHasNotTransfered($q)
    {
        return $q->doesntHave('transfer');
    }

    public function scopeCanBeDisplayed($q)
    {
        return $q->hasNotDead()->hasNotTransfered();
    }
}
