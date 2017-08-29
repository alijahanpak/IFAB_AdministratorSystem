<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTinySeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_tiny_seasons')) {
            Schema::create('tbl_tiny_seasons', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('tsUId')->length(10)->unsigned();
                $table->integer('tsSId')->length(10)->unsigned();
                $table->string('tsSubject');
                $table->longText('tsDescription')->nullable();
                $table->timestamps();

                $table->foreign('tsUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('tsSId')
                    ->references('id')->on('tbl_seasons')
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
        Schema::dropIfExists('tbl_tiny_seasons');
    }
}
