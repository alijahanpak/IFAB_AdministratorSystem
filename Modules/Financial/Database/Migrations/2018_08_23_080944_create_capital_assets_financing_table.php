<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsFinancingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_financing')) {
            Schema::create('tbl_capital_assets_financing', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cafCaaId')->length(20)->unsigned();
                $table->bigInteger('cafRId')->length(20)->unsigned();
                $table->boolean('cafAccepted')->default(0);
                $table->unsignedBigInteger('cafAmount');
                $table->timestamps();

                $table->foreign('cafRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cafCaaId')
                    ->references('id')->on('tbl_capital_assets_allocation')
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
        Schema::dropIfExists('tbl_capital_assets_financing');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
