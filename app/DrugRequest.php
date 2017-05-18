<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{


    protected $table = "drug_request";

    public function pharmacies()
    {
        return $this->hasMany('App\Pharmacy','drug_request_id','id')->withTimestamps();
    }

}
