<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_contracts')) {
            Schema::create('tbl_contracts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cRId')->length(20)->unsigned();
                $table->string('cSubject');
                $table->bigInteger('cAmount');
                $table->tinyInteger('cPercentInAndDec');
                $table->boolean('cIsAccepted')->default(false);
                $table->string('cLetterNumber');
                $table->string('cLetterDate');
                $table->string('cStartDate');
                $table->string('cEndDate');
                $table->longText('cDescription');
                $table->timestamps();

                $table->foreign('cRId')
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
        Schema::dropIfExists('tbl_contracts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
