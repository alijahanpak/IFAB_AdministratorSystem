<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmountUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_amount_units')) {
            Schema::create('tbl_amount_units', function (Blueprint $table) {
                $table->increments('id');
                $table->string('auSubject');
                $table->bigInteger('auAmount');
                $table->longText('auDescription')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_amount_units');
    }
}