<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook')->nullable()->after('image');
            $table->string('linkedin')->nullable()->after('facebook');
            $table->string('skype')->nullable()->after('linkedin');
            $table->boolean('staff_member')->nullable()->after('skype');
            $table->boolean('send_welcome_email')->nullable()->after('staff_member');
            $table->string('default_language')->nullable()->after('send_welcome_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('send_welcome_email');
            $table->dropColumn('is_administrator');
            $table->dropColumn('staff_member');
            $table->dropColumn('skype');
            $table->dropColumn('linkedin');
            $table->dropColumn('facebook');
            $table->dropColumn('default_language');
        });
    }
}
