<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecuritySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sites_schedule')->unsigned();
            $table->integer('id_security_plan')->unsigned();
            $table->integer('id_security_real')->unsigned();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security_schedules');
    }
}
