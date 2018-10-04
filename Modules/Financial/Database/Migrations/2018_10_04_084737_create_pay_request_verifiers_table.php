<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayRequestVerifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_pay_request_verifiers')) {
            Schema::create('tbl_pay_request_verifiers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('prvSId')->length(20)->unsigned()->nullable();
                $table->bigInteger('prvPrId')->length(20)->unsigned();
                $table->bigInteger('prvPrstId')->length(20)->unsigned();
                $table->bigInteger('prvUId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('prvSId')
                    ->references('id')->on('tbl_signatures')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('prvPrId')
                    ->references('id')->on('tbl_pay_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('prvPrstId')
                    ->references('id')->on('tbl_pay_request_steps')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('prvUId')
                    ->references('id')->on('users')
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
        Schema::dropIfExists('tbl_pay_request_verifiers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
