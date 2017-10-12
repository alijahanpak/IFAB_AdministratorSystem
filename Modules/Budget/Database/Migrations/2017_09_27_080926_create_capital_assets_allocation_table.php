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
        if (!Schema::hasTable('tbl_capital_assets_allocation')) {
            Schema::create('tbl_capital_assets_allocation', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('caaUId')->length(10)->unsigned();
                $table->integer('caaCcsId')->length(10)->unsigned();
                $table->string('caaLetterNumber')->nullable();
                $table->string('caaLetterDate')->nullable();
                $table->longText('caaDescription')->nullable();
                $table->timestamps();

                $table->foreign('caaUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('caaCcsId')
                    ->references('id')->on('tbl_cap_credit_source')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('tbl_capital_assets_allocation');
    }
}
