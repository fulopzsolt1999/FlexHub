<?php

namespace App\Http\Controllers;

use App\Models\Gyms;
use Illuminate\Http\Request;

class GymsController extends Controller
{
   public function GetAllGyms()
   {
      $gyms = Gyms::all();
      return response()->json($gyms);
   }
}
