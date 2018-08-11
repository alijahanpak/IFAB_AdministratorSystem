<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_steps')) {
            Schema::create('tbl_request_steps', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rstRtId')->length(20)->unsigned();
                $table->bigInteger('rstCId')->length(20)->unsigned();
                $table->tinyInteger('rstOrder');
                $table->boolean('rstIsRequire')->default(true);
                $table->timestamps();

                $table->foreign('rstRtId')
                    ->references('id')->on('tbl_request_types')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rstCId')
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
        Schema::dropIfExists('tbl_request_steps');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
