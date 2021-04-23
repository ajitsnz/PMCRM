<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name');
            $table->unsignedInteger('customer_id');
            $table->boolean('calculate_progress_through_tasks')->nullable();
            $table->string('progress')->nullable();
            $table->integer('billing_type');
            $table->integer('status');
            $table->string('estimated_hours')->nullable();
            $table->date('start_date');
            $table->date('deadline');
            $table->text('description')->nullable();
            $table->boolean('send_email');
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
        Schema::drop('projects');
    }
}
