<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('note')->nullable();
            $table->unsignedInteger('expense_category_id');
            $table->dateTime('expense_date');
            $table->double('amount');
            $table->unsignedInteger('customer_id')->nullable();
            $table->integer('currency');
            $table->boolean('tax_applied')->default(false);
            $table->unsignedInteger('tax_1_id')->nullable();
            $table->unsignedInteger('tax_2_id')->nullable();
            $table->double('tax_rate')->nullable();
            $table->unsignedInteger('payment_mode_id')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('billable')->default(false);
            $table->timestamps();

            $table->foreign('expense_category_id')->references('id')->on('expense_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('customer_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tax_1_id')->references('id')->on('tax_rates')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tax_2_id')->references('id')->on('tax_rates')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('payment_mode_id')->references('id')->on('payment_modes')
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
        Schema::dropIfExists('expenses');
    }
}
