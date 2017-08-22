<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_budget_seasons')) {
            Schema::create('tbl_budget_seasons', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('bsUId')->length(10)->unsigned();
                $table->string('bsSubject');
                $table->longText('bsDescription')->nullable();
                $table->timestamps();

                $table->foreign('bsUId')
                    ->references('id')->on('users')
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
        Schema::dropIfExists('tbl_budget_seasons');
    }
}
