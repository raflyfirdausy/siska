<?php

namespace App\Models\Access;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Access\Role', 'permission_role', 'permission_id', 'role_id');
    }
}
