<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubSystemPartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_sub_system_parts')) {
            Schema::create('tbl_sub_system_parts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('sspSsId')->length(10)->unsigned();
                $table->string('sspSubject');
                $table->string('sspPart')->unique();
                $table->timestamps();

                $table->foreign('sspSsId')
                    ->references('id')->on('tbl_sub_system')
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
        Schema::dropIfExists('tbl_sub_system_parts');
    }
}
