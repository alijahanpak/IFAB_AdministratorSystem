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
                $table->increments('id');
                $table->integer('hcSsId')->length(10)->unsigned();
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
        Schema::dropIfExists('tbl_help_category');
    }
}
