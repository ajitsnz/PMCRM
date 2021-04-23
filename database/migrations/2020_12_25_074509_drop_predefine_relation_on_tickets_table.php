<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPredefineRelationOnTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_predefined_reply_id_foreign');

            $table->foreign('predefined_reply_id')->references('id')->on('predefined_replies')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }
}
