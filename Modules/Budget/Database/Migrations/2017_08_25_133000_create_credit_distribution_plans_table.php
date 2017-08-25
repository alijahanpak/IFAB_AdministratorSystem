<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditDistributionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_credit_distribution_plans')) {
            Schema::create('tbl_credit_distribution_plans', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cdpUId')->length(10)->unsigned();
                $table->integer('cdpCoId')->length(10)->unsigned();
                $table->integer('cdpCdtId')->length(10)->unsigned();
                $table->integer('cdpCdrId')->length(10)->unsigned();
                $table->integer('cdpFyId')->length(10)->unsigned();
                $table->bigInteger('cdpCredit');
                $table->longText('cdpDescription')->nullable();
                $table->timestamps();

                $table->foreign('cdpUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cdpCoId')
                    ->references('id')->on('tbl_counties')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cdpCdtId')
                    ->references('id')->on('tbl_credit_distribution_titles')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cdpCdrId')
                    ->references('id')->on('tbl_credit_distribution_rows')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cdpFyId')
                    ->references('id')->on('tbl_fiscal_years')
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
        Schema::dropIfExists('tbl_credit_distribution_plans');
    }
}
