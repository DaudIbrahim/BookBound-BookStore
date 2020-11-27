<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * https://laravel.com/docs/5.8/eloquent-relationships#eager-loading
     * 
     * Nested Eager Loading 'stocks.book'
     * 
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['stocks.book', 'status', 'user', 'area', 'coupon'];

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
