<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_id');
            $table->string('country_id')->nullable();            
            $table->integer('fixed')->nullable();
            $table->integer('price')->nullable();

            $table->integer('capacity')->nullable();
            $table->integer('minute')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('hour')->nullable();
            
            $table->string('calculator')->default(0);  
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('service_mappings');
    }
}
