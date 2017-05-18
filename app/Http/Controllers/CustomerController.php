<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function generateCustomer($id)
   {
      if($id!='12345')
      {
         return response()->json("invalid new customer",500);
      }
      try{
      $customer= new Customer();
      $customer->save();
      $customer->name="user".($customer->id) ."";
      $customer->save();

      $user=new User();
      $user->type="1";
      $user->name=$customer->name;
      //$user->customer_id=$customer->id;
      $user->save();
      }
      catch (Exception $e)
      {
       return response()->json($e->getMessage(),200);
      }
      $response["customer"]=$customer;
      $response["user"]=$user;
      return response()->json($response,200);


   }

}
