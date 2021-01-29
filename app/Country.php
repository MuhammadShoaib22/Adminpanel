<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
 

   protected $fillable = [
       'code', 'name', 'dial_code', 'currency_name' , 'currency_symbol' ,'currency_code','status'
   ];


    public function timezone()
    {
        return $this->hasMany('App\TimeZone','country_code','code');
    }
    /**
     * The services that belong to the user.
     */
    public function state()
    {
        return $this->hasMany('App\State');
    }
    /**
     * The services that belong to the user.
     */
    public function city()
    {
        return $this->hasMany('App\Cities');
    }

}
