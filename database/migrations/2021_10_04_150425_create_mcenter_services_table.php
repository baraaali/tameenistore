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
            $table->unsignedBigInteger('mcenter_id');
            $table->unsignedBigInteger('mcenter_vehicle_id')->unsigned();;
            $table->string('ar_name');
            $table->string('en_name');
            $table->text('ar_description');
            $table->decimal('price');
            $table->text('en_description');
            $table->enum('status',['0','1'])->default('0');
            $table->foreign('mcenter_id')->references('id')->on('mcenters')->constrained()->onDelete('cascade');
           // $table->foreign('mcenter_vehicle_id')->references('id')->on('mcenter_vehicles')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('mcenter_services');
    }
}
