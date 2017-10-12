<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsApprovedPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_approved_plan')) {
            Schema::create('tbl_capital_assets_approved_plan', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('capUId')->length(10)->unsigned();
                $table->integer('capCdtId')->length(10)->unsigned();
                $table->integer('capFyId')->length(10)->unsigned();
                $table->string('capLetterNumber');
                $table->string('capLetterDate');
                $table->string('capExchangeDate');
                $table->string('capExchangeIdNumber');
                $table->boolean('capProvinceOrNational');
                $table->longText('capDescription')->nullable();
                $table->timestamps();

                $table->foreign('capUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('capCdtId')
                    ->references('id')->on('tbl_credit_distribution_titles')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('capFyId')
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
        Schema::dropIfExists('tbl_capital_assets_approved_plan');
    }
}
