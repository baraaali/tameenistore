<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AutoNotification', function (Blueprint $table) {
            $table->id();
            $table->text('subject');
            $table->text('body');
            $table->string('purpose');
            $table->enum('to',['user','admin'])->nullable();
            $table->enum('status',['active','deactive'])->nullable();
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
        Schema::dropIfExists('auto_notifications');
    }
}
