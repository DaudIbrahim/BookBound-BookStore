<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Coupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'percent', 'quantity',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isExpired()
    {
        return $this->quantity === 0;
    }

    /**
     * Get current AUTO_INCREMENT value for `coupons` table
     * Genrate 4 Random Upper Case Letters
     */
    public function idGenerate()
    {
        $db = env('DB_DATABASE');
        $select = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES ";
        $select .= "WHERE TABLE_SCHEMA = '$db' AND   TABLE_NAME   = 'coupons'";
        
        $id = DB::select($select)[0]->AUTO_INCREMENT;
        $r = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
        return $id . $r;
    }
}
