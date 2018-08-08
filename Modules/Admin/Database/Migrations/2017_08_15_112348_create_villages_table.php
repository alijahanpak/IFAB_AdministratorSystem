<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_villages')) {
            Schema::create('tbl_villages', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('viUId')->length(20)->unsigned();
                $table->bigInteger('viRdId')->length(20)->unsigned();
                $table->string('viName');
                $table->timestamps();

                $table->foreign('viUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('viRdId')
                    ->references('id')->on('tbl_rural_districts')
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
        Schema::dropIfExists('tbl_villages');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
