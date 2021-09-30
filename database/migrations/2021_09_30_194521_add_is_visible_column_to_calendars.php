<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVisibleColumnToCalendars extends Migration
{
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->unsignedTinyInteger('visible')->default(1);
        });
    }

    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropColumn('visible');
        });
    }
}
