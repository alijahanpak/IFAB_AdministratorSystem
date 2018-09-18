<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRefundCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_refund_costs')) {
            Schema::create('tbl_refund_costs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rcFId')->length(20)->unsigned();
                $table->bigInteger('rcRId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('rcFId')
                    ->references('id')->on('tbl_factors')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('rcRId')
                    ->references('id')->on('tbl_requests')
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
        Schema::dropIfExists('tbl_refund_costs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
