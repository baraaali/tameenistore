<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMiniSubCatNotNullServicesNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mcenters', function (Blueprint $table) {
            $table->integer('sub_category')->nullable(true)->change();
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
            $table->integer('sub_category')->nullable(false)->change();
        });
    }
}
