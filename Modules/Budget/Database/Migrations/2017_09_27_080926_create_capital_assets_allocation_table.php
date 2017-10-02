<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_capital_assets_allocation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caaUId')->length(10)->unsigned();
            $table->integer('caaCpId')->length(10)->unsigned();
            $table->string('caaLetterNumber')->nullable();
            $table->string('caaLetterDate')->nullable();
            $table->timestamps();

            $table->foreign('caaUId')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('caaCpId')
                ->references('id')->on('tbl_capital_assets_projects')
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
        Schema::dropIfExists('tbl_capital_assets_allocation');
    }
}
