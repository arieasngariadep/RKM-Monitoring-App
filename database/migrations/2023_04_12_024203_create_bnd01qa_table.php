<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBnd01qaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bnd01qa', function (Blueprint $table) {
            $table->id();
            $table->date('report_dte')->nullable();
            $table->string('merch_id', 50)->nullable();
            $table->string('card_nbr', 50)->nullable();
            $table->string('amount', 50)->nullable();
            $table->date('txn_dte')->nullable();
            $table->string('rrn', 16)->nullable();
            $table->string('description', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnd01qa');
    }
}
