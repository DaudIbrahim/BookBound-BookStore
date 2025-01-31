<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
