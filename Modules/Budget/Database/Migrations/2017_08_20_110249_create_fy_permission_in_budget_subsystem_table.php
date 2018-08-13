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
                $table->bigIncrements('id');
                $table->bigInteger('pbFyId')->length(20)->unsigned();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_fy_permission_in_budget_subsystem');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
