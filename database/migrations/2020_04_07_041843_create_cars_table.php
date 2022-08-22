<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('en_name')->nullable();
            $table->string('ar_name')->nullable();
            $table->string('ar_model')->nullable();
            $table->string('en_model')->nullable();
            $table->string('ar_brand')->nullable();
            $table->string('year')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->constrained()->onDelete('cascade');
            $table->string('color')->nullable();
            $table->string('type_of_car')->nullable();
            $table->string('transmission')->nullable();
            $table->string('fuel')->nullable();
            $table->string('used')->nullable();
            $table->longText('en_description')->nullable();
            $table->longText('ar_description')->nullable();
            $table->longText('en_features')->nullable();
            $table->longText('ar_features')->nullable();
            $table->integer('special')->default('0');
            $table->integer('visitors')->default('0');
            $table->integer('status')->default('0');
            
            $table->softDeletes();
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
        Schema::dropIfExists('cars');
    }
}
