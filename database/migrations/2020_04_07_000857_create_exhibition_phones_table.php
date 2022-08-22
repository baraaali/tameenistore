<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitionPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exhbitor_id');
            $table->foreign('exhbitor_id')->references('id')->on('exhibitions')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            
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
        Schema::dropIfExists('exhibition_phones');
    }
}
