<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'amount',
        'no_of_days',
        'rides_per_period',
        'order_fee_booking',
        'order_fee_dispatch',
        'transaction_fee_cash',
        'transaction_fee_terminal',
        'transaction_fee_third_party',
        'transaction_fee_bank_card',
        'provider_commission'
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
     * The subscription that belong to the subscription histories.
     */
    public function subscription_histories()
    {
        return $this->hasmany('App\SubscriptionHistories');
    }
}
