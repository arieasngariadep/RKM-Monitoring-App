<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexBnd01qaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bnd01qa', function (Blueprint $table)
        {
            $table->index('report_dte');
            $table->index('merch_id');
            $table->index('card_nbr');
            $table->index('mdr');
            $table->index('amount');
            $table->index('txn_dte');
            $table->index('rrn');
            $table->index('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bnd01qa', function (Blueprint $table)
        {
            $table->index('report_dte');
            $table->index('merch_id');
            $table->index('card_nbr');
            $table->index('mdr');
            $table->index('amount');
            $table->index('txn_dte');
            $table->index('rrn');
            $table->index('description');
        });
    }
}
