<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostFoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_founds')) {
            Schema::create('tbl_cost_founds', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cfCaId')->length(20)->unsigned();
                $table->bigInteger('cfRId')->length(20)->unsigned();
                $table->bigInteger('cfAmount');
                $table->timestamps();

                $table->foreign('cfRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cfCaId')
                    ->references('id')->on('tbl_cost_allocation')
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
        Schema::dropIfExists('tbl_cost_founds');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
