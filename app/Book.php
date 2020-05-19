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

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
    
    public function newStock()
    {
        $newStock = $this->stock->where('is_used', false);
        if ($newStock->count() !== 1) { throw new \ErrorException('More Than One: New-Stock-Records'); }
        return $newStock->first();
    }

    public function usedStock()
    {
        $usedStock = $this->stock->where('is_used', true);
        if ($usedStock->count() !== 1) { throw new \ErrorException('More Than One: Used-Stock-Records'); }
        return $usedStock->first();
    }

    public function getCategory()
    {
        return $this->subcategory->category;
    }
}
