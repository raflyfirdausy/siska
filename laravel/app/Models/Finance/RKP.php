<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class RKP extends Model
{
    protected $table = 'rkp';
    public $timestamps = false;
    protected $guarded = ['id', 'category'];

    public function rpjm()
    {
        return $this->belongsTo('App\Models\Finance\RPJM');
    }
}
