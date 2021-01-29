<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
 

   protected $fillable = [
       'iso_3166_3', 'country_code', 'name', 'status' 
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
    

}
