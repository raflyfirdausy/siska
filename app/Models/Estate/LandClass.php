<?php

namespace App\Models\Estate;

use Illuminate\Database\Eloquent\Model;

class LandClass extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getHargaAttribute()
    {
        return "Rp " . number_format($this->attributes['price'], 2, '.', ',');
    }
}
