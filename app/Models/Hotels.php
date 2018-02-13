<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    protected $guarded=[];
    public function businesv(){
        return $this->hasMany(Busines::class,'id','business');
    }

    public function subwayv()
    {
        return $this->hasMany(Subways::class,'id','subway');
    }
}
