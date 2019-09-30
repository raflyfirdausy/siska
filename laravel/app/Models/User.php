<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $rememberTokenName = false;
    
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Access\Role');
    }

    public function canAccess($role)
    {
        return $this->role->permissions()->where('route_name', $role)->first() ? true : false;
    }
}
