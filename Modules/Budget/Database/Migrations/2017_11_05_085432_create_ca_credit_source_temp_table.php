<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaCreditSourceTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_ca_credit_source_temp')) {
            Schema::create('tbl_ca_credit_source_temp', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ccsUId')->length(10)->unsigned();
                $table->integer('ccsCdrId')->length(10)->unsigned();
                $table->integer('ccsTsId')->length(10)->unsigned();
                $table->integer('ccsCaId')->length(10)->unsigned();
                $table->integer('ccsCdtId')->length(10)->unsigned();
                $table->integer('ccsCcsId')->length(10)->unsigned()->nullable();
                $table->bigInteger('ccsAmount');
                $table->tinyInteger('ccsDeleted')->default(0);
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
                    ->references('id')->on('tbl_cost_tiny_season')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccsCdtId')
                    ->references('id')->on('tbl_credit_distribution_titles')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccsCaId')
                    ->references('id')->on('tbl_cost_agreement_temp')
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
        Schema::dropIfExists('tbl_ca_credit_source_temp');
    }
}
