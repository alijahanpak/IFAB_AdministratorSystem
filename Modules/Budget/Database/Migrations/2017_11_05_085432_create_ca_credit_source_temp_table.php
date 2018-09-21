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
                $table->bigIncrements('id');
                $table->bigInteger('ccsUId')->length(20)->unsigned();
                $table->bigInteger('ccsCdrId')->length(20)->unsigned();
                $table->bigInteger('ccsTsId')->length(20)->unsigned();
                $table->bigInteger('ccsCaId')->length(20)->unsigned();
                $table->bigInteger('ccsCdtId')->length(20)->unsigned();
                $table->bigInteger('ccsCcsId')->length(20)->unsigned()->nullable();
                $table->unsignedBigInteger('ccsAmount');
                $table->unsignedTinyInteger('ccsDeleted')->default(0);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_ca_credit_source_temp');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
