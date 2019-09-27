<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class LaborMigration extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];
    protected $dates = ['departure_date', 'duration'];

    public function bureau()
    {
        return $this->belongsTo('App\Models\Residency\LaborBureau', 'labor_bureau_id');
    }

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }
}
