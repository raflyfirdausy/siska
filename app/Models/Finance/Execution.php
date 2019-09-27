<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Execution extends Model
{
    public $timestamps = false;
    protected $guarded = ['id', 'category'];

    public function rpjm()
    {
        return $this->belongsTo('App\Models\Finance\RPJM');
    }

    public function documentations()
    {
        return $this->hasMany('App\Models\Finance\ExecutionDocumentation', 'execution_id');
    }

    public function getDokumentasiAttribute()
    {
        return collect($this->documentations)->map(function ($data) {
            return asset($data->url);
        });
    }
    
    public function source()
    {
        return $this->belongsTo('App\Models\Finance\BudgetSource', 'budget_source_id');
    }
}
