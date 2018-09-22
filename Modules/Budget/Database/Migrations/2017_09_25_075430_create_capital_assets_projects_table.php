<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_projects')) {
            Schema::create('tbl_capital_assets_projects', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cpUId')->length(20)->unsigned();
                $table->bigInteger('cpCapId')->length(20)->unsigned();
                $table->bigInteger('cpCoId')->length(20)->unsigned()->nullable();
                $table->bigInteger('cpCpId')->length(20)->unsigned()->nullable();
                $table->string('cpSubject');
                $table->string('cpCode');
                $table->string('cpStartYear');
                $table->string('cpEndOfYear');
                $table->boolean('cpActive')->default(true);
                $table->unsignedTinyInteger('cpDeleted')->default(0);
                $table->unsignedTinyInteger('cpPhysicalProgress')->default(0);
                $table->longText('cpDescription')->nullable();
                $table->timestamps();

                $table->foreign('cpUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cpCapId')
                    ->references('id')->on('tbl_capital_assets_approved_plan')
                    ->onDelete('restrict')
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
        Schema::dropIfExists('tbl_capital_assets_projects');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
