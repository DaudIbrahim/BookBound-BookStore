<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'is_used', 'price', 'price'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Many to Many (order_stock)
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withTimestamps()
            ->withPivot('quantity', 'price');
}
}
