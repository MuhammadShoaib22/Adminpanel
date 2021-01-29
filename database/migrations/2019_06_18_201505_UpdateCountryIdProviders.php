<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCountryIdProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->integer('country_id')->default(0)->after('id'); 
        });
        Schema::table('dispatchers', function (Blueprint $table) {
            $table->integer('country_id')->default(0)->after('id'); 
        });
        Schema::table('fleets', function (Blueprint $table) {
            $table->integer('country_id')->default(0)->after('id'); 
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('country_id')->default(0)->after('id'); 
        });
        Schema::table('admin_wallet', function (Blueprint $table) {
            $table->integer('requested_country_id')->default(0)->after('id'); 
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
            $table->dropColumn('country_id'); 
        });
        Schema::table('dispatchers', function (Blueprint $table) {
            $table->dropColumn('country_id'); 
        });
        Schema::table('fleets', function (Blueprint $table) {
            $table->dropColumn('country_id'); 
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('country_id'); 
        });
        Schema::table('admin_wallet', function (Blueprint $table) {
            $table->dropColumn('requested_country_id'); 
        });
    }
}
