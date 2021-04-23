<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('customer_id');
            $table->integer('status');
            $table->integer('currency');
            $table->string('estimate_number');
            $table->string('reference')->nullable();
            $table->unsignedInteger('sales_agent_id')->nullable();
            $table->integer('discount_type')->nullable();
            $table->dateTime('estimate_date');
            $table->dateTime('estimate_expiry_date')->nullable();
            $table->text('admin_note')->nullable();
            $table->double('discount')->nullable();
            $table->integer('unit');
            $table->double('sub_total')->nullable();
            $table->string('adjustment')->default(0);
            $table->text('client_note')->nullable();
            $table->text('term_conditions')->nullable();
            $table->double('total_amount')->nullable();
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
        Schema::drop('estimates');
    }
}
