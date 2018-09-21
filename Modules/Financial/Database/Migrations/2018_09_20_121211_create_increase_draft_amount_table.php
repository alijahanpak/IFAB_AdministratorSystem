<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncreaseDraftAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_increase_draft_amount')) {
            Schema::create('tbl_increase_draft_amount', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('idaDId')->length(20)->unsigned();
                $table->bigInteger('idaPiId')->length(20)->unsigned();
                $table->unsignedBigInteger('idaAmount');
                $table->timestamps();

                $table->foreign('idaDId')
                    ->references('id')->on('tbl_drafts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('idaPiId')
                    ->references('id')->on('tbl_percentage_increases')
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
        Schema::dropIfExists('tbl_increase_draft_amount');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
