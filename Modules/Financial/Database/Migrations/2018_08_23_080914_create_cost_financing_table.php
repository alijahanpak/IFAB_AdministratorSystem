<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCostFinancingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_financing')) {
            Schema::create('tbl_cost_financing', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cfCaId')->length(20)->unsigned();
                $table->bigInteger('cfRId')->length(20)->unsigned();
                $table->boolean('cfAccepted')->default(false);
                $table->boolean('cfDeleted')->default(false);
                $table->unsignedBigInteger('cfAmount');
                $table->timestamps();

                $table->foreign('cfRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cfCaId')
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
        Schema::dropIfExists('tbl_cost_financing');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
