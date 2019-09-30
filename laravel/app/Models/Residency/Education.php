<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    public $timestamps = false;

    protected $table = 'educations';

    public function residents()
    {
        return $this->hasMany('App\Models\Residency\Resident');
    }
}
