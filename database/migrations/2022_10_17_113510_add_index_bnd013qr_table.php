<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexBnd013qrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bnd013qr', function (Blueprint $table) {
            $table->index('report_dte');
            $table->index('org');
            $table->index('merch_id');
            $table->index('card_nbr');
            $table->index('amount');
            $table->index('tc');
            $table->index('txn_dte');
            $table->index('auth_cd');
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
        Schema::table('bnd013qr', function (Blueprint $table)
        {
            $table->index('report_dte');
            $table->index('org');
            $table->index('merch_id');
            $table->index('card_nbr');
            $table->index('amount');
            $table->index('tc');
            $table->index('txn_dte');
            $table->index('auth_cd');
            $table->index('rrn');
            $table->index('description');
        });
    }
}
