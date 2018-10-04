<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayRequestStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_pay_request_steps')) {
            Schema::create('tbl_pay_request_steps', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('prstCId')->length(20)->unsigned();
                $table->unsignedTinyInteger('prstOrder');
                $table->timestamps();

                $table->foreign('prstCId')
                    ->references('id')->on('tbl_categories')
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
        Schema::dropIfExists('tbl_pay_request_steps');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
