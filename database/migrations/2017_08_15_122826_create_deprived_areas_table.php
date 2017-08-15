<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeprivedAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deprived_areas')) {
            Schema::create('tbl_deprived_areas', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('daUId')->length(10)->unsigned();
                $table->integer('daCoId')->length(10)->unsigned();
                $table->integer('daReId')->length(10)->unsigned();
                $table->integer('daRdId')->length(10)->unsigned();
                $table->integer('daViId')->length(10)->unsigned();
                $table->string('daDescription');
                $table->timestamps();

                $table->foreign('daUId')
                    ->references('id')->on('tbl_users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('daCoId')
                    ->references('id')->on('tbl_counties')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('daReId')
                    ->references('id')->on('tbl_regions')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('daRdId')
                    ->references('id')->on('tbl_rural_districts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('daViId')
                    ->references('id')->on('tbl_villages')
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
        Schema::dropIfExists('tbl_deprived_areas');
    }
}
