<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_agreement')) {
            Schema::create('tbl_cost_agreement', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('caUId')->length(20)->unsigned();
                $table->bigInteger('caFyId')->length(20)->unsigned();
                $table->bigInteger('caCaId')->length(20)->unsigned()->nullable()->default(null);
                $table->string('caLetterNumber');
                $table->string('caLetterDate');
                $table->string('caExchangeDate')->nullable();
                $table->string('caExchangeIdNumber')->nullable();
                $table->boolean('caProvinceOrNational');
                $table->boolean('caActive')->default(true);
                $table->longText('caDescription')->nullable();
                $table->timestamps();

                $table->foreign('caUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('caFyId')
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
        Schema::dropIfExists('tbl_cost_agreement');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
