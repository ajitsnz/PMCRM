<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_departments', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('department_id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('department_id')->references('id')->on('departments')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_departments', function (Blueprint $table) {
            $table->dropForeign('user_departments_user_id_foreign');
            $table->dropForeign('user_departments_department_id_foreign');
        });

        Schema::dropIfExists('user_departments');
    }
}
