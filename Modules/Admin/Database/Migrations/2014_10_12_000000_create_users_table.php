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
                $table->increments('id');
                $table->integer('seInPutAmount')->length(10)->unsigned();
                $table->integer('seDispAmount')->length(10)->unsigned();
                $table->integer('seFiscalYear')->nullable()->length(10)->unsigned();
                $table->string('name');
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
        Schema::dropIfExists('users');
    }
}
