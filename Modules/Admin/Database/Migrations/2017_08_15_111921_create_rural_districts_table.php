<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuralDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_rural_districts')) {
            Schema::create('tbl_rural_districts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rdUId')->length(20)->unsigned();
                $table->bigInteger('rdReId')->length(20)->unsigned();
                $table->string('rdName');
                $table->timestamps();

                $table->foreign('rdUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rdReId')
                    ->references('id')->on('tbl_regions')
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
        Schema::dropIfExists('tbl_rural_districts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
