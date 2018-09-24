<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_levels')) {
            Schema::create('tbl_request_levels', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('rlSubject');
                $table->string('rlLevel');
                $table->timestamps();
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
        Schema::dropIfExists('tbl_request_levels');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
