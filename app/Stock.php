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

    /**
     * The relationships that should always be loaded.
     * 
     * Throws Error (Possibly Recursive Error )
     * As stock and orders are eager loaded by the model
     * Not Eager Loading Stock in the Model
     *
     * @var array
     */
    # protected $with = ['orders'];

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
