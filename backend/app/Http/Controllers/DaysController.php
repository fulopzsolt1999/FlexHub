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
}
