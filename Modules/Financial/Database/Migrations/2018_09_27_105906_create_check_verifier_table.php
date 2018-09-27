<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckVerifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_check_verifier')) {
            Schema::create('tbl_check_verifier', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cvUId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('cvUId')
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
        Schema::dropIfExists('tbl_check_verifier');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
