<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    public function nums()
    {
        return $this->hasMany(CouponUser::class, 'coupon_id');
    }

    public function no_use_num()
    {
        return $this->hasMany(CouponUser::class, 'coupon_id');
    }

    public function user()
    {
        return $this->belongsToMany(WxUser::class, 'coupon_users', 'openid', 'coupon_id');
    }
}
