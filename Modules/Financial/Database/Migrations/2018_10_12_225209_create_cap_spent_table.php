<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapSpentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cap_spents')) {
            Schema::create('tbl_cap_spents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('csCafId')->length(20)->unsigned();
                $table->bigInteger('csCId')->length(20)->unsigned();
                $table->unsignedBigInteger('csAmount');
                $table->timestamps();

                $table->foreign('csCafId')
                    ->references('id')->on('tbl_capital_assets_financing')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('csCId')
                    ->references('id')->on('tbl_checks')
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
        Schema::dropIfExists('tbl_cap_spents');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
