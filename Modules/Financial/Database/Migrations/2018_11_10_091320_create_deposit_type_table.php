<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_deposit_types')) {
            Schema::create('tbl_deposit_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('dtSubject');
                $table->string('dtType');
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
        Schema::dropIfExists('tbl_deposit_types');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
