<?php

namespace App\Models\Secretariat;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $dates = ['date'];

    public function getRekomendasiAttribute()
    {
        if ($this->attributes['recommendation'] == 'bpd') {
            return 'BPD';
        } 

        $rec = $this->attributes['recommendation'];
        $rec = explode('_', $rec);
        for ($i = 0; $i < count($rec); $i++) {
            $rec[$i] = ucfirst($rec[$i]);
        }

        return implode(' ', $rec);
    }
}
