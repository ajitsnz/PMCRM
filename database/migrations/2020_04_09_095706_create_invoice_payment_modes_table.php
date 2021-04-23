<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payment_modes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_mode_id');
            $table->unsignedInteger('invoice_id');
            $table->timestamps();

            $table->foreign('payment_mode_id')->references('id')->on('payment_modes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_payment_modes');
    }
}
