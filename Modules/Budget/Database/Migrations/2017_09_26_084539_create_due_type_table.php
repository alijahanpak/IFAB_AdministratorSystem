<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDueTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_due_type')) {
            Schema::create('tbl_due_type', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('dtType');
                $table->string('dtSubject');
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
        Schema::dropIfExists('tbl_due_type');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
