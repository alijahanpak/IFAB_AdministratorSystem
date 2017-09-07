<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditDistributionTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_credit_distribution_titles')) {
            Schema::create('tbl_credit_distribution_titles', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cdtUId')->length(10)->unsigned();
                $table->integer('cdtBsId')->length(10)->unsigned();
                $table->integer('cdtCoId')->length(10)->unsigned()->nullable();
                $table->integer('cdtCdtId')->length(10)->unsigned()->nullable();
                $table->string('cdtIdNumber')->unique();
                $table->string('cdtSubject');
                $table->longText('cdtDescription')->nullable();
                $table->timestamps();

                $table->foreign('cdtUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cdtBsId')
                    ->references('id')->on('tbl_budget_seasons')
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
        Schema::dropIfExists('tbl_credit_distribution_titles');
    }
}
