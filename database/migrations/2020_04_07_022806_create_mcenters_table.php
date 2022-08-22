<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcenters', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->string('en_name')->nullable();
            $table->string('ar_name')->nullable();
            $table->longText('en_address')->nullable();
            $table->longText('ar_address')->nullable();
            $table->longText('phones')->nullable();
            $table->string('image')->nullable();
            $table->string('days_on')->nullable();
            $table->string('times_on')->nullable();
            $table->string('google_map')->nullable();
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
        Schema::dropIfExists('mcenters');
    }
}
