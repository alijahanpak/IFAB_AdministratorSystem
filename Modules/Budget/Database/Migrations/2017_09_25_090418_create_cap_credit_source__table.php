<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapCreditSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cap_credit_source')) {
            Schema::create('tbl_cap_credit_source', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ccsUId')->length(10)->unsigned();
                $table->integer('ccsCdrId')->length(10)->unsigned();
                $table->integer('ccsTsId')->length(10)->unsigned();
                $table->integer('ccsHtrId')->length(10)->unsigned();
                $table->bigInteger('ccsAmount');
                $table->longText('ccsDescription')->nullable();
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
        Schema::dropIfExists('tbl_cap_credit_source');
    }
}
