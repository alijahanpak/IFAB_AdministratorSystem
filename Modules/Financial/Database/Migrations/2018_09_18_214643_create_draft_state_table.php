<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_draft_states')) {
            Schema::create('tbl_draft_states', function (Blueprint $table) {
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
        Schema::dropIfExists('tbl_draft_states');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
