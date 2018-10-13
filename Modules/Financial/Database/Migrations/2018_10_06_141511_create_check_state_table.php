<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_check_states')) {
            Schema::create('tbl_check_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('csSubject');
                $table->string('csState');
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
        Schema::dropIfExists('tbl_check_states');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
