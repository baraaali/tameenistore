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
        Schema::table('services_new', function (Blueprint $table) {
            $table->integer('mini_sub_cat')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_new', function (Blueprint $table) {
            $table->integer('mini_sub_cat')->nullable(false)->change();
        });
    }
}
