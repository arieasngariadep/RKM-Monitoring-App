<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuKreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kartuKredit', function (Blueprint $table) {
            $table->id();
            $table->string('mid',9)->nullable();
            $table->string('mname',50)->nullable();
            $table->string('bankName',255)->nullable();
            $table->string('noRek',16)->nullable();
            $table->string('namaRek',100)->nullable();
            $table->date('proc_date')->nullable();
            $table->string('oo_batch',7)->nullable();
            $table->date('txn_date')->nullable();
            $table->string('auth',6)->nullable();
            $table->string('cardnum',20)->nullable();
            $table->string('amount',14)->nullable();
            $table->string('rate',11)->nullable();
            $table->string('disc_amount',13)->nullable();
            $table->string('net_amount',15)->nullable();
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('id')->on('KkTcReport')->onDelete('cascade');
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
        Schema::dropIfExists('kartu_kredit');
    }
}
