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
                $table->increments('id');
                $table->integer('gpGId')->length(10)->unsigned();
                $table->integer('gpPId')->length(10)->unsigned();
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
        Schema::dropIfExists('tbl_group_permissions');
    }
}
