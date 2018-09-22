<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_attachments')) {
            Schema::create('tbl_attachments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('aRId')->length(20)->unsigned();
                $table->string('aPath');
                $table->string('aName');
                $table->unsignedInteger('aSize');
                $table->timestamps();

                $table->foreign('aRId')
                    ->references('id')->on('tbl_requests')
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
        Schema::dropIfExists('tbl_attachments');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
