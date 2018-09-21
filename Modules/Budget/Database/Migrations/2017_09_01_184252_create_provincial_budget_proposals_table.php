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
                $table->bigIncrements('id');
                $table->bigInteger('pbpUId')->length(20)->unsigned();
                $table->bigInteger('pbpCdpId')->length(20)->unsigned();
                $table->bigInteger('pbpFyId')->length(20)->unsigned();
                $table->string('pbpCode');
                $table->string('pbpSubject');
                $table->unsignedBigInteger('pbpAmount');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_provincial_budget_proposals');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
