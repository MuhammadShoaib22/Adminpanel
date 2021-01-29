<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceMapping extends Model
{
            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id', 'country_id','city_id','price','status','calculator','fixed','distance','hour','minute','capacity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at', 'updated_at'
    ];

        /**
     * The services that belong to the user.
     */
    public function world()
    {
        return $this->hasMany('App\Cities','id','city_id');
    }

            /**
     * The services that belong to the user.
     */
    public function type()
    {
        return $this->hasOne('App\ServiceType','id','service_id');
    }
 
    
    public function country()
    {
        // return $this->hasOne('App\Country','id','country_id');
    }
}
