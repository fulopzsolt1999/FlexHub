<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    protected $table = 'days';
    protected $fillable = ['id', 'name'];
}
