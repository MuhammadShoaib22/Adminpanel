<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderSubscriptionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('provider_subscription_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id');
            $table->integer('provider_id'); 
            $table->string('payment_id');
            $table->enum('status',['subscribe','unsubscribe']); 
            $table->timestamps();
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_subscription_logs');
      
    }
}
