<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_group_permissions')) {
            Schema::create('tbl_group_permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('gpGId')->length(20)->unsigned();
                $table->bigInteger('gpPId')->length(20)->unsigned();
                $table->timestamps();

                $table->foreign('gpGId')
                    ->references('id')->on('tbl_groups')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('gpPId')
                    ->references('id')->on('tbl_permissions')
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
        Schema::dropIfExists('tbl_group_permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
