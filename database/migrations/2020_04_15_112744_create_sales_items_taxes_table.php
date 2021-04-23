<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_item_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_item_id');
            $table->unsignedInteger('tax_id');
            $table->timestamps();

            $table->foreign('tax_id')->references('id')->on('tax_rates')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('sales_item_id')->references('id')->on('sales_items')
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
        Schema::dropIfExists('sales_item_taxes');
    }
}
