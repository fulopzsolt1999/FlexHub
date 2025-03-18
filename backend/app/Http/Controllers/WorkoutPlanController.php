<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;

class WorkoutPlanController extends Controller
{
    public function GetWorkoutPlan(Request $request)
    {
        try {
            $exercises = WorkoutPlan::where('user_id', $request->userId)
                ->where('day_id', $request->dayId)
                ->join('exercises', 'workout_plans.exercise_id', '=', 'exercises.id')
                ->select('workout_plans.*', 'exercises.name', 'exercises.image')
                ->get();
            return response()->json($exercises);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hiba történt', 'error' => $e->getMessage()], 500);
        }
    }

    public function SaveWorkoutPlan(Request $request)
    {
        try {
            WorkoutPlan::where('user_id', $request->userId)->where('day_id', $request->day_id)->delete();
            foreach ($request->exercises as $exercise) {
                WorkoutPlan::create([
                    'user_id' => $exercise['user_id'],
                    'muscle_group_id' => $exercise['muscle_group_id'],
                    'exercise_id' => $exercise['exercise_id'],
                    'day_id' => $exercise['day_id'],
                    'series' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                    'Comment' => $exercise['comment'],
                ]);
            }
            return response()->json(['message' => 'Edzésterv hozzáadva']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hiba történt', 'error' => $e->getMessage()], 500);
        }
    }
}
