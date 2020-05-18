<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'isbn_10', 'isbn_13', 
        'image', 'published_date', 'description',
        'page_count', 'lang', 'publisher',
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function getCategory()
    {
        return $this->subcategory->category;
    }
}
