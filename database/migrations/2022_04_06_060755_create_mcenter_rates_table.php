<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcenterRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcenter_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('maintenance_request_id');
            $table->integer('quality');
            $table->integer('delivery_time');
            $table->integer('delay_again');
            $table->text('notes')->nullable();
            $table->timestamps();
            // $table->foreign('user_id')->references('users')->on('id')->onDelete('cascade');
            // $table->foreign('maintenance_request_id')->references('maintenance_requests')->on('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcenter_rates');
    }
}
