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
                $table->bigIncrements('id');
                $table->bigInteger('bsUId')->length(20)->unsigned();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_budget_seasons');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
