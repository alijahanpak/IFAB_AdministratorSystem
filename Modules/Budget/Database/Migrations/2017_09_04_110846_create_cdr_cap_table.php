<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdrCapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cdr_cap')) {
            Schema::create('tbl_cdr_cap', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ccUId')->length(10)->unsigned();
                $table->integer('ccCdrId')->length(10)->unsigned();
                $table->integer('ccCapId')->length(10)->unsigned();
                $table->bigInteger('ccAmount');
                $table->timestamps();

                $table->foreign('ccUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccCdrId')
                    ->references('id')->on('tbl_credit_distribution_rows')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ccCapId')
                    ->references('id')->on('tbl_capital_assets_approved_plan')
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
        Schema::dropIfExists('tbl_cdr_cap');
    }
}
