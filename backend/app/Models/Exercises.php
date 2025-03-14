<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    protected $table = 'exercises';
    protected $fillable = ['id', 'name', 'muscle_group_id', 'image', 'video'];
}
