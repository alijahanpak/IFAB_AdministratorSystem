<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_expense_costs')) {
            Schema::create('tbl_expense_costs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('ecUId')->length(20)->unsigned();
                $table->bigInteger('ecCaId')->length(20)->unsigned()->nullable();
                $table->string('ecSubject');
                $table->unsignedBigInteger('ecAmount');
                $table->longText('ecDescription')->nullable();
                $table->timestamps();

                $table->foreign('ecUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ecCaId')
                    ->references('id')->on('tbl_cost_allocation')
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
        Schema::dropIfExists('tbl_expense_costs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
