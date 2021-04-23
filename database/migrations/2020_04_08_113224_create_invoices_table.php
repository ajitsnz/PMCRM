<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('customer_id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->unsignedInteger('sales_agent_id')->nullable();
            $table->integer('currency');
            $table->integer('discount_type')->nullable();
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

            $table->foreign('sales_agent_id')->references('id')->on('users')
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
        Schema::drop('invoices');
    }
}
