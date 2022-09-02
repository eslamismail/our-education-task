<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->float('paidAmount')->default(0);
            $table->string('currency');
            // make parent email work as index
            $table->string('parentEmail')->index();
            // make parent key as foreign key refers on users
            $table->foreign('parentEmail')->references('email')->on('users');
            $table->integer('statusCode');
            $table->timestamp('paymentDate');
            $table->string('parentIdentification');
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
        Schema::dropIfExists('transactions');
    }
}
