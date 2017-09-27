<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdrCaaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cdr_caa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ccCdrId')->length(10)->unsigned();
            $table->integer('ccCaaId')->length(10)->unsigned();
            $table->bigInteger('ccAmount');
            $table->timestamps();

            $table->foreign('ccCdrId')
                ->references('id')->on('tbl_credit_distribution_rows')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('ccCaaId')
                ->references('id')->on('tbl_capital_assets_allocation')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_cdr_caa');
    }
}
