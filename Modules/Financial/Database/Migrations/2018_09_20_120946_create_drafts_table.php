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
                $table->string('dFor');
                $table->string('dPayTo');
                $table->unsignedBigInteger('dBaseAmount');
                $table->unsignedBigInteger('dAmount');
                $table->string('dLetterNumber')->nullable();
                $table->string('dLetterDate')->nullable();
                $table->timestamps();

                $table->foreign('dRId')
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
        Schema::dropIfExists('tbl_drafts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
