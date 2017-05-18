<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

  protected  $table='users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',"role"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function admin()
    {
      return $this->hasOne('App\Admin','admin_id');
    }
    public function customer()
    {
      return $this->hasOne('App\Customer','customer_id');
    }

    public function pharmacy()
    {
      //return $this->hasOne('App\Pharmacy','id');
    }

}

