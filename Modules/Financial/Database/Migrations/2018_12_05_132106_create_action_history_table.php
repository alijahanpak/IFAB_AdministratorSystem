<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_action_history')) {
            Schema::create('tbl_action_history', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->longText('ahLog');
                $table->bigInteger('ahRhId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('ahRhId')
                    ->references('id')->on('tbl_request_history')
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
        Schema::dropIfExists('tbl_action_history');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
