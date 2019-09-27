<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function getJabatanAttribute()
    {
        $position = $this->attributes['position'];
        $position = explode('_', $position);
        for ($i = 0; $i < count($position); $i++) {
            if ($position[$i] != 'dan') {
                $position[$i] = ucfirst($position[$i]);
            }
        }

        return implode(' ', $position);
    }

    public function getFotoAttribute()
    {
        return asset($this->attributes['photo']);
    }
}
