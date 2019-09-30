<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class ExecutionDocumentation extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function execution()
    {
        return $this->belongsTo('App\Models\Finance\Execution');
    }
}
