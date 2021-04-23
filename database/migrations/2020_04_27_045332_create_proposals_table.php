<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proposal_number')->unique();
            $table->string('title');
            $table->string('related_to')->nullable();
            $table->dateTime('date');
            $table->dateTime('open_till')->nullable();
            $table->integer('currency');
            $table->integer('discount_type')->nullable();
            $table->integer('status');
            $table->integer('assigned_user_id')->nullable();
            $table->string('phone')->nullable();
            $table->double('discount')->nullable();
            $table->integer('unit');
            $table->double('sub_total')->nullable();
            $table->string('adjustment')->default(0);
            $table->double('total_amount')->nullable();
            $table->integer('payment_status')->nullable();
            $table->integer('owner_id')->nullable();
            $table->string('owner_type')->nullable();
            $table->integer('discount_symbol')->nullable();
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
        Schema::dropIfExists('proposals');
    }
}
