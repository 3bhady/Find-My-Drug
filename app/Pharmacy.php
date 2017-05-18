<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $table="pharmacies";

  public function user()
  {
      return $this->hasOne('App\User','user_id','id')->withTimestamps();
  }


    public function drug_request()
    {
        return $this->belongsTo('App\DrugRequest','id','drug_request_id')->withTimestamps();
    }
}
