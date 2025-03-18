<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    protected $table = 'workout_plans';
    protected $fillable = ['user_id', 'day_id', 'muscle_group_id', 'exercise_id', 'series', 'reps', 'Comment'];
    public $timestamps = false;
}
