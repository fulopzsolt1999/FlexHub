<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
   public function GetAllAddress()
   {
      $addresses = Addresses::GetAll();
      return response()->json($addresses);
   }

   public function GetAddress($id)
  {
     $id = (int) $id;
     $address = Addresses::find($id);
     if ($address) {
        return response()->json($address);
     } else {
        return response()->json(['message' => 'Address not found'], 404);
     }
  }
}
