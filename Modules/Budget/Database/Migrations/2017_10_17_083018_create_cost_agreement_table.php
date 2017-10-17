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
                $table->increments('id');
                $table->integer('caUId')->length(10)->unsigned();
                $table->integer('caFyId')->length(10)->unsigned();
                $table->string('caLetterNumber');
                $table->string('caLetterDate');
                $table->string('caExchangeDate');
                $table->string('caExchangeIdNumber');
                $table->boolean('caProvinceOrNational');
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
        Schema::dropIfExists('tbl_cost_agreement');
    }
}
