<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';
    public $timestamps = true;
    protected $guarded = ['id'];
}
