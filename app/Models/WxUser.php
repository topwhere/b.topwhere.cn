<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WxUser extends Model
{
    //
    public function grade(){
        return $this->hasMany(Config::class, 'id','grade');
    }
}
