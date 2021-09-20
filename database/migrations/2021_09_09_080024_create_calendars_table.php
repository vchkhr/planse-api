<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('color')->default(0);
            $table->char('name', 100);
            $table->char('description', 200)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('main_calendar')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendars');

        if (Schema::hasColumn('users', 'main_calendar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('main_calendar');
            });
        }
    }
}
