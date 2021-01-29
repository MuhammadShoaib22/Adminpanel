<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserrequestArrivedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->timestamp('arrived_at')->nullable()->after('schedule_at'); 
            $table->integer('waiting_time')->default(0)->after('schedule_at'); 
        });
        Schema::table('user_request_payments', function (Blueprint $table) {
            $table->double('waiting_charge',10,2)->default(0)->after('hour');  
            $table->double('wallet_deduction',10,2)->default(0)->after('hour');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->dropColumn('arrived_at'); 
            $table->dropColumn('waiting_time'); 
        });
        Schema::table('user_request_payments', function (Blueprint $table) {
            $table->dropColumn('waiting_charge');  
            $table->dropColumn('wallet_deduction');  
        });
    }
}
