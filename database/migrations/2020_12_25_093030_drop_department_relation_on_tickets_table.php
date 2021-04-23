<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDepartmentRelationOnTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_contact_id_foreign');
            $table->dropForeign('tickets_department_id_foreign');
            $table->dropForeign('tickets_assign_to_foreign');

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('department_id')->references('id')->on('departments')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('assign_to')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }
}
