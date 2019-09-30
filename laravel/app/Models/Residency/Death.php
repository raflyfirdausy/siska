<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class Death extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $dates = ['date_of_death'];

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function getPenentuKematianAttribute()
    {
        $determinant = $this->attributes['determinant'];
        $determinant = explode('_', $determinant);
        for ($i = 0; $i < count($determinant); $i++) {
            $determinant[$i] = ucfirst($determinant[$i]);
        }

        return implode(' ', $determinant);
    }

    public function getTempatKematianAttribute()
    {
        $place = $this->attributes['place_of_death'];
        $place = explode('_', $place);
        for ($i = 0; $i < count($place); $i++) {
            $place[$i] = ucfirst($place[$i]);
        }

        return implode(' ', $place);
    }

    public function getHubunganPelaporAttribute()
    {
        return ucfirst($this->attributes['reporter_relation']);
    }
}
