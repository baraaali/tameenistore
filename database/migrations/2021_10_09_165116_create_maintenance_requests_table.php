<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('mcenter_id');
            $table->integer('user_id');
            $table->string('services');
            $table->decimal('price');
            $table->string('additional_services')->nullable();
            $table->enum('delivery_to',['workshop','house']);
            $table->string('delivery_day');
            $table->enum('status',['in review','approved','rejected','canceled','finished'])->default('in review');
            $table->string('delivery_time');
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
        Schema::dropIfExists('maintenance_requests');
    }
}
