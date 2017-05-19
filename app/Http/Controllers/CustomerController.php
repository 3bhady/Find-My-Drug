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
         $i=$customer->id;
      $customer->name="user".($customer->id) ."";
      $customer->save();
         $n=$customer->name;

      $user=new User();
      $user->type="1";
      $user->name=$n;
      //$user->customer_id=$customer->id;
      $user->save();
         
         $edittedCustomer=Customer::find($customer->id);
         $edittedCustomer->user_id=$user->id;
         $edittedCustomer->save();
         
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
