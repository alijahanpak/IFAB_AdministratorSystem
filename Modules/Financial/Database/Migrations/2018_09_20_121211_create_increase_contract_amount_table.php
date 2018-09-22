<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncreaseContractAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_increase_contract_amount')) {
            Schema::create('tbl_increase_contract_amount', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('icaCId')->length(20)->unsigned();
                $table->bigInteger('icaPiId')->length(20)->unsigned();
                $table->unsignedBigInteger('icaAmount');
                $table->timestamps();

                $table->foreign('icaCId')
                    ->references('id')->on('tbl_contracts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('icaPiId')
                    ->references('id')->on('tbl_percentage_increases')
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
        Schema::dropIfExists('tbl_increase_contract_amount');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
