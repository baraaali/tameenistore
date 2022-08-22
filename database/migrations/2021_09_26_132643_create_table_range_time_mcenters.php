<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRangeTimeMcenters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('range_time_mcenters', function (Blueprint $table) {
            $table->id();
            $table->integer('mcenter_id');
            $table->enum('day',['all_days','sunday','monday','tuesday','wednesday','thursday','friday','saturday']);
            $table->string('start_time');
            $table->string('end_time');
            $table->timestamps();

            $table->foreign('mcenter_id')->references('mcenters')->on('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_range_time_mcenters');
    }
}
