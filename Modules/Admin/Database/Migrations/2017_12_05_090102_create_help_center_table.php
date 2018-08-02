<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_help_center')) {
            Schema::create('tbl_help_center', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('hceHcId')->length(20)->unsigned();
                $table->string('hceSubject');
                $table->string('hceImgName');
                $table->longText('hceDescription');
                $table->timestamps();

                $table->foreign('hceHcId')
                    ->references('id')->on('tbl_help_category')
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
        Schema::dropIfExists('tbl_help_center');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
