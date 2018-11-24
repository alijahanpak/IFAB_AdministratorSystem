<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_pay_requests')) {
            Schema::create('tbl_pay_requests', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('prRId')->length(20)->unsigned();
                $table->bigInteger('prPrsId')->length(20)->unsigned();
                $table->bigInteger('prCId')->length(20)->unsigned();
                $table->unsignedTinyInteger('prPhysicalProgress');
                $table->unsignedTinyInteger('prAmountProgress');
                $table->unsignedBigInteger('prAmount');
                $table->boolean('prIsFinal')->default(false);
                $table->string('prLetterNumber')->unique()->nullable();
                $table->string('prLetterDate')->nullable();
                $table->longText('prDescription')->nullable();
                $table->timestamps();

                $table->foreign('prRId')
                    ->references('id')->on('tbl_requests')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('prPrsId')
                    ->references('id')->on('tbl_pay_request_states')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('prCId')
                    ->references('id')->on('tbl_categories')
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
        Schema::dropIfExists('tbl_pay_requests');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
