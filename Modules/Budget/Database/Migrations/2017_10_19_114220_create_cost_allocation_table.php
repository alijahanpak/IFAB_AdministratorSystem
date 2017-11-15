<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_cost_allocation')) {
            Schema::create('tbl_cost_allocation', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('caUId')->length(10)->unsigned();
                $table->integer('caCcsId')->length(10)->unsigned()->nullable();
                $table->integer('caFyId')->length(10)->unsigned()->nullable();
                $table->integer('caFoundId')->length(10)->unsigned()->nullable();
                $table->string('caLetterNumber')->nullable();
                $table->string('caLetterDate')->nullable();
                $table->boolean('caFound')->default(false);
                $table->bigInteger('caAmount');
                $table->longText('caDescription')->nullable();
                $table->timestamps();

                $table->foreign('caUId')
                    ->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('caCcsId')
                    ->references('id')->on('tbl_ca_credit_source')
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
        Schema::dropIfExists('tbl_cost_allocation');
    }
}
