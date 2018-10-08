<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestHistoryLastPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_history_last_points')) {
            Schema::create('tbl_request_history_last_points', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rhlpRId')->length(20)->unsigned();
                $table->bigInteger('rhlpRlId')->length(20)->unsigned();
                $table->bigInteger('rhlpRsId')->length(20)->unsigned();
                $table->bigInteger('rhlpPrId')->length(20)->unsigned()->nullable();
                $table->longText('rhlpDescription');
                $table->timestamps();

                $table->foreign('rhlpRId')
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
        Schema::dropIfExists('tbl_request_history_last_points');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
