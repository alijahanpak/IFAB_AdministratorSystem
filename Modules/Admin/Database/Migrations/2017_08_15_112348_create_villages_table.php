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
                $table->increments('id');
                $table->integer('viUId')->length(10)->unsigned();
                $table->integer('viRdId')->length(10)->unsigned();
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
        Schema::dropIfExists('tbl_villages');
    }
}
