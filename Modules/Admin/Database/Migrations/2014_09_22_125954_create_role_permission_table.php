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
        if (!Schema::hasTable('tbl_role_permissions')) {
            Schema::create('tbl_role_permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('rpRId')->length(10)->unsigned();
                $table->integer('rpPId')->length(10)->unsigned();
                $table->timestamps();

                $table->foreign('rpRId')
                    ->references('id')->on('tbl_roles')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rpPId')
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
        Schema::dropIfExists('tbl_role_permissions');
    }
}
