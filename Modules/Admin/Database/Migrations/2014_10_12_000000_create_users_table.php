<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users'))
        {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('seInPutAmount')->length(20)->unsigned();
                $table->bigInteger('seDispAmount')->length(20)->unsigned();
                $table->bigInteger('seFiscalYear')->nullable()->length(20)->unsigned();
                $table->bigInteger('rId')->length(20)->unsigned();
                $table->string('name');
                $table->string('avatarPath')->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();

                $table->foreign('seInPutAmount')
                    ->references('id')->on('tbl_amount_units')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('seDispAmount')
                    ->references('id')->on('tbl_amount_units')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rId')
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
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
