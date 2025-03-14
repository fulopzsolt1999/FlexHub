<?php

namespace App\Http\Controllers;

use App\Models\Days;
use Illuminate\Http\Request;

class DaysController extends Controller
{
   public function GetAllDays()
   {
      $days = Days::all();
      return response()->json($days);
   }

   public function GetDay($id)
   {
      $day = Days::find($id);
      if ($day) {
         return response()->json($day);
      } else {
         return response()->json(['message' => 'Day not found'], 404);
      }
   }
}
