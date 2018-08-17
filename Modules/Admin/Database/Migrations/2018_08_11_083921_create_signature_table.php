<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_signatures')) {
            Schema::create('tbl_signatures', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('sUId')->length(20)->unsigned();
                $table->boolean('sState')->default(true);
                $table->string('sPath');
                $table->timestamps();

                $table->foreign('sUId')
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
        Schema::dropIfExists('tbl_signatures');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
