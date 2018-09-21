<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftsVerifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_draft_verifiers')) {
            Schema::create('tbl_draft_verifiers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('dvSId')->length(20)->unsigned()->nullable();
                $table->bigInteger('dvDId')->length(20)->unsigned();
                $table->bigInteger('dvUId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('dvSId')
                    ->references('id')->on('tbl_signatures')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('dvDId')
                    ->references('id')->on('tbl_drafts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('dvUId')
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
        Schema::dropIfExists('tbl_draft_verifiers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
