<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsProjectTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_projects_temp')) {
            Schema::create('tbl_capital_assets_projects_temp', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cpUId')->length(10)->unsigned();
                $table->integer('cpCapId')->length(10)->unsigned();
                $table->integer('cpCoId')->length(10)->unsigned()->nullable();
                $table->integer('cpCpId')->length(10)->unsigned()->nullable();
                $table->string('cpSubject');
                $table->string('cpCode');
                $table->string('cpStartYear');
                $table->string('cpEndOfYear');
                $table->tinyInteger('cpPhysicalProgress')->default(0);
                $table->tinyInteger('cpDeleted')->default(0);
                $table->longText('cpDescription')->nullable();
                $table->timestamps();

                $table->foreign('cpUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cpCapId')
                    ->references('id')->on('tbl_capital_assets_approved_plan_temp')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('cpCoId')
                    ->references('id')->on('tbl_counties')
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
        Schema::dropIfExists('tbl_capital_assets_projects_temp');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
