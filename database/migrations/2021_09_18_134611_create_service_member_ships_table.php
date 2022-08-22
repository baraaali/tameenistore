<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceMemberShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_member_ships', function (Blueprint $table) {
            $table->id();
            $table->string('ar_name');
            $table->string('en_name');
            $table->integer('category');
            $table->integer('sub_category')->nullable();
            $table->integer('child_category')->nullable();
            $table->enum('type',['normal','special'])->default('normal');
            $table->enum('status',['0','1'])->default('0');
            $table->integer('ads_number');
            $table->integer('months_number');
            $table->decimal('price')->default(0);

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
        Schema::dropIfExists('service_member_ships');
    }
}
