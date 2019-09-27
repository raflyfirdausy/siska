<?php

namespace App\Models\Access;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Access\Permission', 'permission_role', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
