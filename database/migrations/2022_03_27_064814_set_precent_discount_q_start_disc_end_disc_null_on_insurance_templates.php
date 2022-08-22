<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetPrecentDiscountQStartDiscEndDiscNullOnInsuranceTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurance_templates', function (Blueprint $table) {
            $table->integer('precent')->nullable(true)->change();
            $table->integer('discount_q')->nullable(true)->change();
            $table->date('start_disc')->nullable(true)->change();
            $table->date('end_disc')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurance_templates', function (Blueprint $table) {
            //
        });
    }
}
