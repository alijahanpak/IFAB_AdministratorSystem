<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestAcceptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_accepts')) {
            Schema::create('tbl_request_accepts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('aSId')->length(20)->unsigned();
                $table->bigInteger('aRstId')->length(20)->unsigned();
                $table->bigInteger('aRId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('aSId')
                    ->references('id')->on('tbl_signatures')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('aRstId')
                    ->references('id')->on('tbl_request_steps')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('aRId')
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
        Schema::dropIfExists('tbl_request_accepts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
