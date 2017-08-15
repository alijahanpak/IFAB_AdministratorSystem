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
                $table->increments('id');
                $table->integer('rdUId')->length(10)->unsigned();
                $table->integer('rdReId')->length(10)->unsigned();
                $table->string('rdName');
                $table->timestamps();

                $table->foreign('rdUId')
                    ->references('id')->on('tbl_users')
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
        Schema::dropIfExists('tbl_rural_districts');
    }
}
