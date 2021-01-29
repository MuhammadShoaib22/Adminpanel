<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id');
            $table->integer('provider_id'); 
            $table->enum('status',['Active','Expired'])->default('Active'); 
            $table->datetime('started_at'); 
            $table->datetime('ended_at');
            $table->timestamps();
        });
        Schema::table('providers', function (Blueprint $table) {
            $table->enum('subscribe', ['subscribed', 'notsubscribed'])->default('notsubscribed')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_histories');
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('subscribe');
        });
    }
}
