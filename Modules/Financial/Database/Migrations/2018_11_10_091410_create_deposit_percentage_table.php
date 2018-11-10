<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositPercentageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deposit_percentages')) {
            Schema::create('tbl_deposit_percentages', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('dpDpcId')->length(20)->unsigned();
                $table->bigInteger('dpDptId')->length(20)->unsigned();
                $table->string('dpSubject');
                $table->unsignedTinyInteger('dpPercent');
                $table->timestamps();

                $table->foreign('dpDpcId')
                    ->references('id')->on('tbl_deposit_percentage_category')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('dpDptId')
                    ->references('id')->on('tbl_deposit_percentage_types')
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
        Schema::dropIfExists('tbl_deposit_percentages');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
