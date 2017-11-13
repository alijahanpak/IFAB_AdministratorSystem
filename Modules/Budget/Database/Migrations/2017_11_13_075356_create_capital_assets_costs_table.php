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
                $table->increments('id');
                $table->integer('cacUId')->length(10)->unsigned();
                $table->integer('cacCaaId')->length(10)->unsigned()->nullable();
                $table->string('cacSubject');
                $table->bigInteger('cacAmount');
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
        Schema::dropIfExists('tbl_capital_assets_costs');
    }
}
