<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProviderStripeCardAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) { 
            $table->string('subscribe_stripe_cust_id')->nullable()->after('stripe_cust_id'); 
        });
        Schema::table('cards', function (Blueprint $table) {
            $table->integer('provider_id')->default(0)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('subscribe_stripe_cust_id'); 
        });
        Schema::table('providers', function (Blueprint $table) {
            $table->string('provider_id'); 
        });
    }
}
