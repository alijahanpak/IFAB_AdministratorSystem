<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRequestHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_request_history')) {
            Schema::create('tbl_request_history', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rhSrcUId')->length(20)->unsigned();
                $table->bigInteger('rhDestUId')->length(20)->unsigned()->nullable();
                $table->bigInteger('rhRId')->length(20)->unsigned();
                $table->bigInteger('rhRsId')->length(20)->unsigned();
                $table->bigInteger('rhDId')->length(20)->unsigned()->nullable();
                $table->boolean('rhIsReferral')->default(false);
                $table->boolean('rhHasBeenSeen')->default(false);
                $table->boolean('rhDHasBeenSeen')->default(false);
                $table->longText('rhDescription')->nullable();
                $table->timestamps();

                $table->foreign('rhSrcUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rhDestUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rhRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rhRsId')
                    ->references('id')->on('tbl_request_states')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('rhDId')
                    ->references('id')->on('tbl_drafts')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('tbl_request_history');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
