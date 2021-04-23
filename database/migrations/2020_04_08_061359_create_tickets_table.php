<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->unsignedInteger('contact_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->string('cc')->nullable();
            $table->unsignedInteger('assign_to')->nullable();
            $table->unsignedInteger('priority_id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('predefined_reply_id')->nullable();
            $table->text('body')->nullable();
            $table->unsignedInteger('ticket_status_id')->nullable();
            $table->timestamps();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('assign_to')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('priority_id')->references('id')->on('ticket_priorities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('service_id')->references('id')->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('predefined_reply_id')->references('id')->on('predefined_replies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ticket_status_id')->references('id')->on('ticket_statuses')
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
        Schema::dropIfExists('tickets');
    }
}
