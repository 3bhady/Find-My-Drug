<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function generateCustomer()
   {
      
      return response()->json("s",200);


   }

}
