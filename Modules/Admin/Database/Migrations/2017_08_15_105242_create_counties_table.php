<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_counties')) {
            Schema::create('tbl_counties', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('coUId')->length(10)->unsigned();
                $table->string('coName');
                $table->timestamps();

                $table->foreign('coUId')
                    ->references('id')->on('users')
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
        Schema::dropIfExists('tbl_counties');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
