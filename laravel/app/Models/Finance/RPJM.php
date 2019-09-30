<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class RPJM extends Model
{
    protected $table = 'rpjm';
    public $timestamps = false;
    protected $guarded = ['id', 'category'];

    public function rkp()
    {
        return $this->hasMany('App\Models\Finance\RKP', 'rpjm_id');
    }

    public function apbd()
    {
        return $this->hasMany('App\Models\Finance\APBD', 'rpjm_id');
    }

    public function execution()
    {
        return $this->hasMany('App\Models\Finance\Execution', 'rpjm_id');
    }
}
