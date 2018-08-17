<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_role_categories')) {
            Schema::create('tbl_role_categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rcRId')->length(20)->unsigned();
                $table->bigInteger('rcCId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('rcCId')
                    ->references('id')->on('tbl_categories')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rcRId')
                    ->references('id')->on('tbl_roles')
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
        Schema::dropIfExists('tbl_role_categories');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
