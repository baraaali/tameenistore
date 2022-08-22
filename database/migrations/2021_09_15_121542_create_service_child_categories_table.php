<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceChildCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_child_categories', function (Blueprint $table) {
            $table->id();
            $table->string('ar_name');
            $table->string('en_name');
            $table->text('ar_description')->nullable();
            $table->text('en_description')->nullable();
            $table->integer('service_sub_category_id');
            $table->enum('status',['0','1'])->default('0');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('service_sub_category_id')->references('service_sub_categories')->on('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_child_categories');
    }
}
