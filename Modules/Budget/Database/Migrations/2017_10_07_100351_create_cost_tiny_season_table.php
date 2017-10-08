<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostTinySeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_tiny_season')) {
            Schema::create('tbl_cost_tiny_season', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ctsUId')->length(10)->unsigned();
                $table->integer('ctsCstId')->length(10)->unsigned();
                $table->string('ctsSubject');
                $table->longText('ctsDescription')->nullable();
                $table->timestamps();

                $table->foreign('ctsUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ctsCstId')
                    ->references('id')->on('tbl_cost_season_title')
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
        Schema::dropIfExists('tbl_cost_tiny_season');
    }
}
