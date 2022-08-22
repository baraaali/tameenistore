<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcenterServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcenter_services', function (Blueprint $table) {
            $table->id();
            $table->integer('mcenter_id');
            $table->integer('mcenter_vehicle_id');
            $table->string('ar_name');
            $table->string('en_name');
            $table->text('ar_description');
            $table->decimal('price');
            $table->text('en_description');
            $table->enum('status',['0','1'])->default('0');
            $table->timestamps();
            $table->foreign('mcenter_id')->references('mcenters')->on('id')->onDelete('cascade');
            $table->foreign('mcenter_vehicle_id')->references('mcenter_vehicles')->on('id')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcenter_services');
    }
}
