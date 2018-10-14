<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRequestTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_types')) {
            Schema::create('tbl_request_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('rtSubject');
                $table->string('rtType');
                $table->string('rtPermission');
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
        Schema::dropIfExists('tbl_request_types');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
