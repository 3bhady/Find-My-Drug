<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
        "chemical_name",
        "generic_name",
        "price",
        "image",
        "category",
        "active_ingredient",
        "form",
        "company","howmany",
        "slug_en"
    ];

   protected $table = "drugs";

    public function users()
    {
        return $this->belongsToMany('App\User','drug_request','drug_id','customer_id')->withTimestamps();
    }

}
