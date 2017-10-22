<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsSeasonTitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_season_title')) {
            Schema::create('tbl_capital_assets_season_title', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('castUId')->length(10)->unsigned();
                $table->integer('castSId')->length(10)->unsigned();
                $table->string('castSubject');
                $table->longText('castDescription')->nullable();
                $table->timestamps();

                $table->foreign('castUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('castSId')
                    ->references('id')->on('tbl_seasons')
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
        Schema::dropIfExists('tbl_capital_assets_season_title');
    }
}
