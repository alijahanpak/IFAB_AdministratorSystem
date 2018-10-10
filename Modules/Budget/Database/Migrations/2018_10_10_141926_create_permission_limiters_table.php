<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionLimitersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_permission_limiters')) {
            Schema::create('tbl_permission_limiters', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('plFyId')->length(20)->unsigned();
                $table->bigInteger('plPId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('plPId')
                    ->references('id')->on('tbl_permissions')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('plFyId')
                    ->references('id')->on('tbl_fiscal_years')
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
        Schema::dropIfExists('tbl_permission_limiters');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
