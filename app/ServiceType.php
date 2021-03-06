<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'provider_name',
        'image',
        'price',
        'fixed',
        'description',
        'status',
        'minute',
        'hour',
        'distance',
        'calculator',
        'capacity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at', 'updated_at'
    ];

     public function mapping(){

        
        return $this->hasOne('App\ServiceMapping','service_id')->where('city_id',Auth::user()->city_id);
    }

    public function fareestimatemapping(){

        
        return $this->hasMany('App\ServiceMapping','service_id');
    }
}
