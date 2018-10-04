<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayRequestStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_pay_request_states')) {
            Schema::create('tbl_pay_request_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('prsSubject');
                $table->string('prsState');
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
        Schema::dropIfExists('tbl_pay_request_states');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
