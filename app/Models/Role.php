<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded=[];
    public function permission()
    {
        return $this->hasMany(PermissionRole::class,'role_id','id');
    }
}
