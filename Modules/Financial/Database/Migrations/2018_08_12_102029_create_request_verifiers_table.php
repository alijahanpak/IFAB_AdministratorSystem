<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRequestVerifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_verifiers')) {
            Schema::create('tbl_request_verifiers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rvSId')->length(20)->unsigned()->nullable();
                $table->bigInteger('rvRstId')->length(20)->unsigned();
                $table->bigInteger('rvRId')->length(20)->unsigned();
                $table->bigInteger('rvUId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('rvSId')
                    ->references('id')->on('tbl_signatures')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rvRstId')
                    ->references('id')->on('tbl_request_steps')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rvRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rvUId')
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
        Schema::dropIfExists('tbl_request_verifiers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
