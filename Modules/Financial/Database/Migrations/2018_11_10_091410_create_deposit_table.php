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
                $table->bigInteger('dDcId')->length(20)->unsigned();
                $table->bigInteger('dDtId')->length(20)->unsigned();
                $table->string('dSubject');
                $table->unsignedTinyInteger('dPercent');
                $table->timestamps();

                $table->foreign('dDcId')
                    ->references('id')->on('tbl_deposit_category')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('dDtId')
                    ->references('id')->on('tbl_deposit_types')
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
