<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_regions')) {
            Schema::create('tbl_regions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('reUId')->length(10)->unsigned();
                $table->integer('reCoId')->length(10)->unsigned();
                $table->string('reName');
                $table->timestamps();

                $table->foreign('reUId')
                    ->references('id')->on('tbl_users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('reCoId')
                    ->references('id')->on('tbl_counties')
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
        Schema::dropIfExists('tbl_regions');
    }
}
