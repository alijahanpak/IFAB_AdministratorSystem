<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSystemLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_system_log')) {
            Schema::create('tbl_system_log', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('slUId')->length(10)->unsigned();
                $table->string('slSubSystem');
                $table->longText('slLogText');
                $table->timestamps();

                $table->foreign('slUId')
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
        Schema::dropIfExists('tbl_system_log');
    }
}
