<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class provider_subscription_log extends Model
{
    

	protected $table = 'provider_subscription_logs';

    protected $fillable = [
        'subscription_id',
        'provider_id',
        'payment_id',
        'status',
       
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at', 'updated_at'
    ];

}
