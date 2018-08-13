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
                $table->bigIncrements('id');
                $table->bigInteger('capUId')->length(20)->unsigned();
                $table->bigInteger('capCdtId')->length(20)->unsigned();
                $table->bigInteger('capFyId')->length(20)->unsigned();
                $table->bigInteger('capCapId')->length(20)->unsigned()->nullable()->default(null);
                $table->string('capLetterNumber');
                $table->string('capLetterDate');
                $table->string('capExchangeDate');
                $table->string('capExchangeIdNumber');
                $table->boolean('capProvinceOrNational');
                $table->boolean('capActive')->default(true);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_capital_assets_approved_plan');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
