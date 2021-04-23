<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->double('rate');
            $table->integer('tax_1_id')->nullable();
            $table->integer('tax_2_id')->nullable();
            $table->unsignedInteger('item_group_id');
            $table->timestamps();

            $table->foreign('item_group_id')->references('id')->on('item_groups')
                ->onDelete('Cascade')
                ->onUpdate('Cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
