<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories() 
    {
        return $this->hasMany(Subcategory::class);
    }

    public function books()
    {
        return $this->hasManyThrough(Book::class, Subcategory::class);
    }
}
