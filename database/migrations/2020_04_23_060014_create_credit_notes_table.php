<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('customer_id');
            $table->string('credit_note_number');
            $table->dateTime('credit_note_date');
            $table->integer('currency');
            $table->integer('discount_type')->nullable();
            $table->string('reference')->nullable();
            $table->double('discount')->nullable();
            $table->text('admin_text')->nullable();
            $table->integer('unit');
            $table->text('client_note')->nullable();
            $table->text('term_conditions')->nullable();
            $table->double('sub_total')->nullable();
            $table->string('adjustment')->default(0);
            $table->double('total_amount')->nullable();
            $table->integer('payment_status')->nullable();
            $table->integer('discount_symbol')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
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
        Schema::dropIfExists('credit_notes');
    }
}
