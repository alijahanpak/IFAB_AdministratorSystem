<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostSeasonTitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_season_title')) {
            Schema::create('tbl_cost_season_title', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cstUId')->length(10)->unsigned();
                $table->integer('cstSId')->length(10)->unsigned();
                $table->string('cstSubject');
                $table->longText('cstDescription')->nullable();
                $table->timestamps();

                $table->foreign('cstUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cstSId')
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
        Schema::dropIfExists('tbl_cost_season_title');
    }
}
