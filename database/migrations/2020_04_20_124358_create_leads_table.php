<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('source_id');
            $table->unsignedInteger('assign_to')->nullable();
            $table->string('company_name');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->double('estimate_budget')->nullable();
            $table->string('default_language')->nullable();
            $table->integer('public')->nullable();
            $table->boolean('lead_convert_customer')->default(false);
            $table->date('lead_convert_date')->nullable();
            $table->integer('contacted_today')->nullable();
            $table->dateTime('date_contacted')->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('lead_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('source_id')->references('id')->on('lead_sources')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('assign_to')->references('id')->on('users')
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
        Schema::drop('leads');
    }
}
