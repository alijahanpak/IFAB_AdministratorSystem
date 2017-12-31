<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_permissions')) {
            Schema::create('tbl_permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pSspId')->length(10)->unsigned();
                $table->string('pSubject');
                $table->string('pPermission')->unique();
                $table->timestamps();

                $table->foreign('pSspId')
                    ->references('id')->on('tbl_sub_system_parts')
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
        Schema::dropIfExists('tbl_permissions');
    }
}
