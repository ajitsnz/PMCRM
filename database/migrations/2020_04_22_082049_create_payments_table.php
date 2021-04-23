<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->string('owner_type');
            $table->double('amount_received');
            $table->dateTime('payment_date');
            $table->unsignedInteger('payment_mode');
            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->boolean('send_mail_to_customer_contacts')->nullable();
            $table->timestamps();

            $table->foreign('payment_mode')->references('id')->on('payment_modes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
