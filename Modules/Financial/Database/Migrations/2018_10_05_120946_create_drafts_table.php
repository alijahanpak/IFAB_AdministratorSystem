<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_drafts')) {
            Schema::create('tbl_drafts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('dRId')->length(20)->unsigned();
                $table->bigInteger('dDsId')->length(20)->unsigned();
                $table->bigInteger('dPrId')->length(20)->unsigned()->nullable();
                $table->string('dFor');
                $table->string('dPayTo');
                $table->unsignedBigInteger('dBaseAmount');
                $table->unsignedBigInteger('dAmount');
                $table->unsignedBigInteger('dSumOfLastDraftAmount');
                $table->unsignedBigInteger('dPureAmount');
                $table->unsignedBigInteger('dSumOfLastDraftPureAmount');
                $table->string('dLetterNumber')->unique()->nullable();
                $table->string('dLetterDate')->nullable();
                $table->boolean('dIsMinute')->default(true);
                $table->timestamps();

                $table->foreign('dRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('dDsId')
                    ->references('id')->on('tbl_draft_states')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('dPrId')
                    ->references('id')->on('tbl_pay_requests')
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
        Schema::dropIfExists('tbl_drafts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
