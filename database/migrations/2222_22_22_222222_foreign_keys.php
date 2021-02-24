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
            $table->foreign('id_people')->references('id')->on('peoples')->onDelete('cascade');
            $table->foreign('id_corporate')->references('id')->on('corporates')->onDelete('cascade');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('id_report')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('id_report_detail')->references('id')->on('report_details')->onDelete('cascade');
            $table->foreign('id_respondent')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('id_security_real')->references('id')->on('securities')->onDelete('cascade');
            $table->foreign('id_security_schedule')->references('id')->on('security_schedules')->onDelete('cascade');
        });
        Schema::table('report_details', function (Blueprint $table) {
            $table->foreign('id_report')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('id_checkpoint')->references('id')->on('checkpoints')->onDelete('cascade');
        });
        
        Schema::table('securities', function (Blueprint $table) {
            $table->foreign('id_people')->references('id')->on('peoples')->onDelete('cascade');
            $table->foreign('id_supervisor')->references('id')->on('securities')->onDelete('cascade');
        });

        Schema::table('security_schedules', function (Blueprint $table) {
            $table->foreign('id_site_schedule')->references('id')->on('site_schedules')->onDelete('cascade');
            $table->foreign('id_security_plan')->references('id')->on('securities')->onDelete('cascade');
        });

        Schema::table('site_schedules', function (Blueprint $table) {
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('id_schedule')->references('id')->on('schedules')->onDelete('cascade');
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->foreign('id_corporate')->references('id')->on('corporates')->onDelete('cascade');
        });

        Schema::table('checkpoints', function (Blueprint $table) {
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_people')->references('id')->on('peoples')->onDelete('cascade');
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
