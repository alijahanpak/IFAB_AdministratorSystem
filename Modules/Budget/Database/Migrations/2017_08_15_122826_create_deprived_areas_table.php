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
                $table->bigIncrements('id');
                $table->bigInteger('daUId')->length(20)->unsigned();
                $table->bigInteger('daCoId')->length(20)->unsigned();
                $table->bigInteger('daReId')->length(20)->unsigned()->nullable();
                $table->bigInteger('daRdId')->length(20)->unsigned()->nullable();
                $table->bigInteger('daViId')->length(20)->unsigned()->nullable();
                $table->longText('daDescription')->nullable();
                $table->timestamps();

                $table->foreign('daUId')
                    ->references('id')->on('users')
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_deprived_areas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
