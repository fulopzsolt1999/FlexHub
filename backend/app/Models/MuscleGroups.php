<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuscleGroups extends Model
{
    protected $table = 'muscle_groups';
    protected $fillable = ['id', 'name'];
}
