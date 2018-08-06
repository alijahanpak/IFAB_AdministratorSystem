<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_user_groups')) {
            Schema::create('tbl_user_groups', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ugUId')->length(10)->unsigned();
                $table->integer('ugGId')->length(10)->unsigned();
                $table->timestamps();

                $table->foreign('ugUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('ugGId')
                    ->references('id')->on('tbl_groups')
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
        Schema::dropIfExists('tbl_user_groups');
    }
}
