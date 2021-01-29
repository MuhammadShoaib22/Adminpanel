<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionHistories extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'subscription_id',
        'provider_id',
        'payment_id',
        'status',
        'started_at',
        'ended_at'
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
     * The subscription histories that belong to the subscription .
     */
    public function subscription()
    {
        return $this->belongsTo('App\Subscriptions');
    }
    /**
     * The subscription histories that belong to the subscription .
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
