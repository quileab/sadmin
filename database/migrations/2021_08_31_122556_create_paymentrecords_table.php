<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentrecords', function (Blueprint $table) {
            $table->id(); // que hace de numero de recibo
            $table->unsignedBigInteger('user_id')->constrained();
            $table->unsignedBigInteger('userpayments_id')->key();

            $table->string('paymentBox'); // quién cobra
            $table->string('description');
            $table->decimal('paymentAmount', 10, 2);

            // el contador de la caja registrará el numero de recibo unico por email de usuario en "config"
            // $table->bigInteger('payBoxCounter')->nullable();
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
        Schema::dropIfExists('paymentrecords');
    }
}
