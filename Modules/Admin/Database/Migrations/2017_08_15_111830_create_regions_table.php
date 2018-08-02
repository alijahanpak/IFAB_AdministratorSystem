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
                $table->bigIncrements('id');
                $table->bigInteger('reUId')->length(20)->unsigned();
                $table->bigInteger('reCoId')->length(20)->unsigned();
                $table->string('reName');
                $table->timestamps();

                $table->foreign('reUId')
                    ->references('id')->on('users')
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tbl_regions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
