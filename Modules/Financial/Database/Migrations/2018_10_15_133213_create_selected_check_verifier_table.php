<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectedCheckVerifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_selected_check_verifiers')) {
            Schema::create('tbl_selected_check_verifiers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('scvCId')->length(20)->unsigned();
                $table->bigInteger('scvCvId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('scvCId')
                    ->references('id')->on('tbl_checks')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('scvCvId')
                    ->references('id')->on('tbl_check_verifier')
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
        Schema::dropIfExists('tbl_selected_check_verifiers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
