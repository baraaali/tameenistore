<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
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
            $table->integer('agent_type')->default('0');
            $table->string('fb_page')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter_page')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('google_map')->nullable();
            $table->string('days_on')->nullable();
            $table->string('times_on')->nullable();
            $table->integer('car_type')->default('0');
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
        Schema::dropIfExists('agents');
    }
}
