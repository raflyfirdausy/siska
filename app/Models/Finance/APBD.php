<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class APBD extends Model
{
    protected $table = 'apbd';
    public $timestamps = false;
    protected $guarded = ['id', 'category'];
    protected $dates = ['start_date', 'end_date'];
    
    public function rpjm()
    {
        return $this->belongsTo('App\Models\Finance\RPJM');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Finance\VillageBusiness', 'village_business_id');
    }
}
