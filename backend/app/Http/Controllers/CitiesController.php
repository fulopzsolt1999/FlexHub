<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
   public function GetAllCities()
   {
      $cities = Cities::all();
      return response()->json($cities);
   }

   public function GetCity($id)
   {
      $city = Cities::find($id);
      if ($city) {
         return response()->json($city);
      } else {
         return response()->json(['message' => 'City not found'], 404);
      }
   }
}
