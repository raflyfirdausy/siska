<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perdes extends Model
{
    protected $table = 'sk_perdes';
    public $timestamps = true;
    protected $guarded = ['id'];
}
