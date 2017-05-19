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


    public function drugrequest()
    {
        return $this->belongsTo("App\DrugRequest",'drug_request_id','id');
        return $this->belongsTo('App\DrugRequest','id','drug_request_id');
    }
}
