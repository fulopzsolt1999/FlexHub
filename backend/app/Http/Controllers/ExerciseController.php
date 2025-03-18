<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercises;

class ExerciseController extends Controller
{
    public function GetByMuscleGroup(Request $request)
    {
        $exercises = Exercises::where('muscle_group_id', $request->muscleGroupId)->get();
        return response()->json($exercises);
    }
}
