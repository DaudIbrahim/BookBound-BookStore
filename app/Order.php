<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Many to Many (order_stock)
    public function stocks()
    {
        return $this->belongsToMany(Stock::class)
            ->withTimestamps()
            ->withPivot('quantity', 'price');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
