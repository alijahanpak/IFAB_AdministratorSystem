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
                $table->bigIncrements('id');
                $table->bigInteger('cdpUId')->length(20)->unsigned();
                $table->bigInteger('cdpCoId')->length(20)->unsigned();
                $table->bigInteger('cdpCdtId')->length(20)->unsigned();
                $table->bigInteger('cdpCdrId')->length(20)->unsigned();
                $table->bigInteger('cdpFyId')->length(20)->unsigned();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_credit_distribution_plans');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
