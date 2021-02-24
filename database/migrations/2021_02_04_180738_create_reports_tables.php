<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_types', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->string('name')->unique();
            $table->string('file_name');
            $table->timestamps();
            $table->timestamp('expired_at')->nullable();

            $table->foreignId('campaign_type_id')->constrained();
        });

        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->integer('zip');
            $table->string('lender');
            $table->integer('funded_amount')->nullable();
            $table->integer('total_revenue')->nullable();
            $table->timestamps();

            $table->foreignId('campaign_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodes');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('campaign_types');
    }
}
