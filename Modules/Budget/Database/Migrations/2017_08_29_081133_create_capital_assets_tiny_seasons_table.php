<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsTinySeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_tiny_seasons')) {
            Schema::create('tbl_capital_assets_tiny_seasons', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('catsUId')->length(10)->unsigned();
                $table->integer('catsCastId')->length(10)->unsigned();
                $table->string('catsSubject');
                $table->longText('catsDescription')->nullable();
                $table->timestamps();

                $table->foreign('catsUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('catsCastId')
                    ->references('id')->on('tbl_capital_assets_season_title')
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
        Schema::dropIfExists('tbl_capital_assets_tiny_seasons');
    }
}
