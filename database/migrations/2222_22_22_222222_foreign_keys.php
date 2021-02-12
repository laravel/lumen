<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('id_people')->references('id')->on('peoples');
            $table->foreign('id_corporate')->references('id')->on('corporates');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('id_report_detail')->references('id')->on('report_details');
            $table->foreign('id_user')->references('id')->on('users');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('id_security_real')->references('id')->on('securities');
            $table->foreign('id_site_schedule')->references('id')->on('site_schedules');
        });
        Schema::table('report_details', function (Blueprint $table) {
            $table->foreign('id_report')->references('id')->on('reports');
            $table->foreign('id_checkpoint')->references('id')->on('checkpoints');
        });
        
        Schema::table('securities', function (Blueprint $table) {
            $table->foreign('id_people')->references('id')->on('peoples');
            $table->foreign('id_supervisor')->references('id')->on('securities');
        });

        Schema::table('security_schedules', function (Blueprint $table) {
            $table->foreign('id_site_schedule')->references('id')->on('site_schedules');
            $table->foreign('id_security_plan')->references('id')->on('securities');
        });

        Schema::table('site_schedules', function (Blueprint $table) {
            $table->foreign('id_site')->references('id')->on('sites');
            $table->foreign('id_schedule')->references('id')->on('schedules');
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->foreign('id_corporate')->references('id')->on('corporates');
        });

        Schema::table('checkpoints', function (Blueprint $table) {
            $table->foreign('id_site')->references('id')->on('sites');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_people')->references('id')->on('peoples');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
