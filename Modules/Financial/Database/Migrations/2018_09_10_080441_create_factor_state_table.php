<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactorStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_factor_states')) {
            Schema::create('tbl_factor_states', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('fsSubject');
                $table->string('fsState');
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
        Schema::dropIfExists('tbl_factor_states');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');;
    }
}
