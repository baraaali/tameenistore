<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceCategoriesToMcenters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mcenters', function (Blueprint $table) {
            $table->integer('category');
            $table->integer('sub_category')->nullable();
            $table->integer('child_category')->nullable();
            $table->integer('store')->nullable();
            $table->text('ar_description');
            $table->text('en_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mcenters', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('sub_category');
            $table->dropColumn('child_category');
            $table->dropColumn('store');
        });
    }
}
