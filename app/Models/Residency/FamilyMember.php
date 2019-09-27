<?php

namespace App\Models\Residency;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    public $timestamps = false;

    public function family()
    {
        return $this->belongsTo('App\Models\Residency\Family');
    }

    public function resident()
    {
        return $this->belongsTo('App\Models\Residency\Resident');
    }

    public function scopeFamilyHead($query)
    {
        return $query->where('relation', 'kepala');
    }

    public function scopeCanBeDisplayed($q)
    {
        return $q->whereHas('resident', function($q) {
            return $q->canBeDisplayed();
        });
    }

    public function getHubunganAttribute()
    {
        $relation = $this->attributes['relation'];
        $relation = explode('_', $relation);
        for ($i = 0; $i < count($relation); $i++) {
            $relation[$i] = ucfirst($relation[$i]);
        }

        return implode(' ', $relation);
    }
}
