<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class LaborBureau extends Model
{
    public $timestamps = false;

    public function migrations()
    {
        return $this->hasMany('App\Models\Residency\LaborMigration', 'labor_bureau_id');
    }
}
