<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_states')) {
            Schema::create('tbl_request_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('rsSubject');
                $table->string('rsState');
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
        Schema::dropIfExists('tbl_request_states');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
