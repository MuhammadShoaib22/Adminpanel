<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriptionFeilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->double('transaction_fee_bank_card',10,2)->default(0)->after('amount'); 
            $table->double('transaction_fee_third_party',10,2)->default(0)->after('amount'); 
            $table->double('transaction_fee_terminal',10,2)->default(0)->after('amount');
            $table->double('transaction_fee_cash',10,2)->default(0)->after('amount');  
            $table->double('order_fee_dispatch',10,2)->default(0)->after('amount'); 
            $table->double('order_fee_booking',10,2)->default(0)->after('amount');
            $table->double('rides_per_period',10,2)->default(0)->after('amount');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('rides_per_period'); 
            $table->dropColumn('order_fee_booking'); 
            $table->dropColumn('order_fee_dispatch'); 
            $table->dropColumn('transaction_fee_cash'); 
            $table->dropColumn('transaction_fee_terminal'); 
            $table->dropColumn('transaction_fee_third_party'); 
            $table->dropColumn('transaction_fee_bank_card'); 
        });
    }
}
