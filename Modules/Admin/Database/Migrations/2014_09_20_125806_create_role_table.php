<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_roles')) {
            Schema::create('tbl_roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rOuId')->length(20)->unsigned();
                $table->string('rSubject');
                $table->string('rRole')->unique();
                $table->timestamps();

                $table->foreign('rOuId')
                    ->references('id')->on('tbl_office_units')
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
        Schema::dropIfExists('tbl_roles');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
