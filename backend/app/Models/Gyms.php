<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gyms extends Model
{
    protected $table = 'gyms';
    protected $fillable = ['id', 'name', 'address_id', 'phone', 'email', 'image'];

}
