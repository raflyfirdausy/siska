<?php

namespace App\Models\Secretariat;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;
    
    protected $dates = [
        'last_login',
        'date_created'
    ];

    protected $guarded = [
        'id',
    ];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident', 'resident_id');
    }
}
