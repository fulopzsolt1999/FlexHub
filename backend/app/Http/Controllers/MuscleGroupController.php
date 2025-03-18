<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MuscleGroups;

class MuscleGroupController extends Controller
{
    public function GetAll()
    {
        $muscleGroups = MuscleGroups::all();
        return response()->json($muscleGroups);
    }
}
