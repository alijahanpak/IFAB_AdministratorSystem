<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deposit_states')) {
            Schema::create('tbl_deposit_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('dsSubject');
                $table->string('dsState');
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
        Schema::dropIfExists('tbl_deposit_states');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
