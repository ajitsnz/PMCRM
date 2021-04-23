
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->nullable();
            $table->boolean('public')->nullable();
            $table->boolean('billable')->nullable();
            $table->string('subject');
            $table->integer('status');
            $table->string('hourly_rate')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('due_date')->nullable();
            $table->integer('priority')->nullable();
            $table->text('description')->nullable();
            $table->integer('related_to')->nullable();
            $table->string('owner_type')->nullable();
            $table->integer('owner_id')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('users')
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
        Schema::dropIfExists('tasks');
    }
}
