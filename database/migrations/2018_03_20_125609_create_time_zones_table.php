<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_id');
            $table->string('country_code');
            $table->string('coordinates');
            $table->string('time_zone');
            $table->string('comments');
            $table->string('utc_offset');
            $table->string('utc_dst_offset');
            $table->string('notes');
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
        Schema::dropIfExists('time_zones');
    }
}
