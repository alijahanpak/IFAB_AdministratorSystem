<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostSpentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_spents')) {
            Schema::create('tbl_cost_spents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('csCfId')->length(20)->unsigned();
                $table->bigInteger('csCId')->length(20)->unsigned();
                $table->unsignedBigInteger('csAmount');
                $table->timestamps();

                $table->foreign('csCfId')
                    ->references('id')->on('tbl_cost_financing')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('csCId')
                    ->references('id')->on('tbl_checks')
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
        Schema::dropIfExists('tbl_cost_spents');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
