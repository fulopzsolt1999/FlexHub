<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestDay extends Model
{
    protected $table = 'rest_days';
    protected $fillable = ['user_id', 'day_id'];
    public $timestamps = false;
}
