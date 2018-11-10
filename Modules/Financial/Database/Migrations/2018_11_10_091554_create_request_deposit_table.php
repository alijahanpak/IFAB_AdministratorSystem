<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_deposits')) {
            Schema::create('tbl_request_deposits', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rdDId')->length(20)->unsigned();
                $table->bigInteger('rdDrId')->length(20)->unsigned();
                $table->bigInteger('rdDsId')->length(20)->unsigned();
                $table->unsignedBigInteger('rdAmount');
                $table->timestamps();

                $table->foreign('rdDId')
                    ->references('id')->on('tbl_deposits')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rdDrId')
                    ->references('id')->on('tbl_drafts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rdDsId')
                    ->references('id')->on('tbl_request_deposit_states')
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
        Schema::dropIfExists('tbl_request_deposits');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
