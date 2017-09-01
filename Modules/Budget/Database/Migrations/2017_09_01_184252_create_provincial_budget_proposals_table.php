<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincialBudgetProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_provincial_budget_proposals')) {
            Schema::create('tbl_provincial_budget_proposals', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pbpUId')->length(10)->unsigned();
                $table->integer('pbpCdpId')->length(10)->unsigned();
                $table->integer('pbpFyId')->length(10)->unsigned();
                $table->string('pbpCode');
                $table->string('pbpSubject');
                $table->bigInteger('pbpAmount');
                $table->longText('pbpDescription')->nullable();
                $table->timestamps();

                $table->foreign('pbpUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('pbpCdpId')
                    ->references('id')->on('tbl_credit_distribution_plans')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('pbpFyId')
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
        Schema::dropIfExists('tbl_provincial_budget_proposals');
    }
}
