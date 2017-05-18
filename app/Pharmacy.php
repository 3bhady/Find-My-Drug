<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $table="pharmacies";




  public function user()
  {
      return $this->hasOne('App\User','id','user_id');
  }
}
