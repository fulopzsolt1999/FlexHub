<?php

namespace App\Http\Controllers;

use App\Models\RestDay;
use Illuminate\Http\Request;

class RestDayController extends Controller
{
    public function GetAllRestDays(Request $request)
    {
        return response()->json(RestDay::where('user_id', (int) $request->userId)->get());
    }

    public function CreateRestDay(Request $request)
    {
        try {
            RestDay::create(
                [
                    'user_id' => (int) $request->userId,
                    'day_id' => (int) $request->dayId
                ]
            );
            return response()->json(['message' => 'Pihenőnap hozzáadva']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hiba történt', 'error' => $e->getMessage()], 500);
        }
    }

    public function DeleteRestDay(Request $request)
    {
        RestDay::where('user_id', (int) $request->userId)->where('day_id', (int) $request->dayId)->delete();
        return response()->json(['message' => 'Pihenőnap törölve']);
    }
}
