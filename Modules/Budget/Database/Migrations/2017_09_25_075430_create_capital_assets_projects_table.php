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
        Schema::create('tbl_capital_assets_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cpUId')->length(10)->unsigned();
            $table->integer('cpCapId')->length(10)->unsigned();
            $table->integer('cpCoId')->length(10)->unsigned();
            $table->integer('cpTsId')->length(10)->unsigned();
            $table->integer('cpHtrId')->length(10)->unsigned();
            $table->string('cpSubject');
            $table->string('cpCode');
            $table->string('cpStartYear');
            $table->string('cpEndOfYear');
            $table->tinyInteger('cpPhysicalProgress')->default(0);
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

            $table->foreign('cpTsId')
                ->references('id')->on('tbl_capital_assets_tiny_seasons')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('cpHtrId')
                ->references('id')->on('tbl_how_to_run')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_capital_assets_projects');
    }
}
