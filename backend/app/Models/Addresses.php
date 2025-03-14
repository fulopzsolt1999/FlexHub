<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $table = 'addresses';
    protected $fillable = ['id', 'city_id', 'street', 'street_number'];

    public static function GetAll()
    {
        return self::all();
    }
}
