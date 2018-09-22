<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalAssetsCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_capital_assets_costs')) {
            Schema::create('tbl_capital_assets_costs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cacUId')->length(20)->unsigned();
                $table->bigInteger('cacCaaId')->length(20)->unsigned()->nullable();
                $table->string('cacSubject');
                $table->unsignedBigInteger('cacAmount');
                $table->longText('cacDescription')->nullable();
                $table->timestamps();

                $table->foreign('cacUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('cacCaaId')
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
        Schema::dropIfExists('tbl_capital_assets_costs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
