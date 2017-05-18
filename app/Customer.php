<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected  $table="customers";

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function drug()
    {
        return $this->belongsToMany('App\Drug','drug_request','customer_id','drug_id');
    }
}
