<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deposits')) {
            Schema::create('tbl_deposits', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('dDpId')->length(20)->unsigned();
                $table->bigInteger('dDrId')->length(20)->unsigned();
                $table->bigInteger('dDsId')->length(20)->unsigned();
                $table->unsignedBigInteger('dAmount');
                $table->timestamps();

                $table->foreign('dDpId')
                    ->references('id')->on('tbl_deposit_percentages')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('dDrId')
                    ->references('id')->on('tbl_drafts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('dDsId')
                    ->references('id')->on('tbl_deposit_states')
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
        Schema::dropIfExists('tbl_deposits');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
