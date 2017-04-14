<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyForm extends Model
{
   protected  $fillable=[
       "name_en",
       "address_en",
       "landline",
       "mobile",
       "email",
       "mobile2",
       "owner_name",
       "password",
       "home_delivery",
       "open",
       "close",
       "name_ar",
       "address_ar"

   ];

    protected $table="pharmacy_forms";

}
