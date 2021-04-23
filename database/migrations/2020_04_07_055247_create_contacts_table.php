<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('position')->nullable();
            $table->boolean('primary_contact')->default(0);
            $table->boolean('send_welcome_email')->default(0);
            $table->boolean('send_password_email')->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->onDelete('Cascade')
                ->onUpdate('Cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('contacts');
    }
}
