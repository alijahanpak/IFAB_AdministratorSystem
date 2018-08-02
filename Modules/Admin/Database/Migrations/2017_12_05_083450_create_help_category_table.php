<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_help_category')) {
            Schema::create('tbl_help_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('hcSsId')->length(20)->unsigned();
                $table->string('hcSubject');
                $table->longText('hcDescription');
                $table->timestamps();

                $table->foreign('hcSsId')
                    ->references('id')->on('tbl_sub_system')
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
        Schema::dropIfExists('tbl_help_category');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
