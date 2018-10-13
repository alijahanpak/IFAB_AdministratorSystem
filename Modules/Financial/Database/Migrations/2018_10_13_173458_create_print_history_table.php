<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_print_history')) {
            Schema::create('tbl_print_history', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('phCId')->length(20)->unsigned();
                $table->dateTime('phDate');
                $table->unsignedBigInteger('phAmount');
                $table->string('phIdNumber');
                $table->string('phVerifierName');
                $table->string('phCheckFormat');
                $table->timestamps();

                $table->foreign('phCId')
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
        Schema::dropIfExists('tbl_print_history');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
