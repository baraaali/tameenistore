<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('ad_type');
            $table->string('ad_id');
            $table->string('countries');
            $table->string('governorates')->nullable();
            $table->string('cities')->nullable();
            $table->string('subject');
            $table->string('image');
            $table->text('body');
            $table->text('notes')->nullable();;
            $table->integer('user_id');
            $table->enum('status',['in review','approved','rejected'])->default('in review');
            $table->timestamps();

            $table->foreign('user_id')->references('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
