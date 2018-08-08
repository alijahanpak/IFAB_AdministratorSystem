<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapCreditSourceTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cap_credit_source_temp')) {
            Schema::create('tbl_cap_credit_source_temp', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('ccsUId')->length(20)->unsigned();
                $table->bigInteger('ccsCdrId')->length(20)->unsigned();
                $table->bigInteger('ccsTsId')->length(20)->unsigned();
                $table->bigInteger('ccsHtrId')->length(20)->unsigned();
                $table->bigInteger('ccsCapId')->length(20)->unsigned();
                $table->bigInteger('ccsCcsId')->length(20)->unsigned()->nullable();
                $table->bigInteger('ccsAmount');
                $table->longText('ccsDescription')->nullable();
                $table->tinyInteger('ccsDeleted')->default(0);
                $table->timestamps();

                $table->foreign('ccsCdrId')
                    ->references('id')->on('tbl_credit_distribution_rows')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccsUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccsTsId')
                    ->references('id')->on('tbl_capital_assets_tiny_seasons')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccsHtrId')
                    ->references('id')->on('tbl_how_to_run')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccsCapId')
                    ->references('id')->on('tbl_capital_assets_projects_temp')
                    ->onDelete('cascade')
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
        Schema::dropIfExists('tbl_cap_credit_source_temp');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
