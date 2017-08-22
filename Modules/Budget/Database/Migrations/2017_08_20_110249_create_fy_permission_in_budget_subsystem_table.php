<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFyPermissionInBudgetSubsystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_fy_permission_in_budget_subsystem')) {
            Schema::create('tbl_fy_permission_in_budget_subsystem', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pbFyId')->length(10)->unsigned();
                $table->boolean('pbTOBudgetOffer')->default(true);
                $table->boolean('pbTMBudgetOffer')->default(true);
                $table->boolean('pbTOCreditDistributionScheme')->default(true);
                $table->boolean('pbTOApprovedPlan')->default(true);
                $table->boolean('pbTMApprovedPlan')->default(true);
                $table->boolean('pbTOApprovedProject')->default(true);
                $table->boolean('pbTMApprovedProject')->default(true);
                $table->boolean('pbTOAllocation')->default(true);
                $table->boolean('pbTMAllocation')->default(true);
                $table->timestamps();

                $table->foreign('pbfyId')
                    ->references('id')->on('tbl_fiscal_years')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            });
        }
        if (!Schema::hasTable('tbl_fy_permission_in_budget_subsystem')) {
            Schema::create('tbl_fy_permission_in_budget_subsystem', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pbFyId')->length(10)->unsigned();
                $table->string('pbFieldName')->unique();
                $table->string('pbLabel');
                $table->boolean('pbStatus')->default(true);
                $table->timestamps();

                $table->foreign('pbfyId')
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
        Schema::dropIfExists('tbl_fy_permission_in_budget_subsystem');
    }
}
