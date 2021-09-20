<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrangementsTable extends Migration
{
    public function up()
    {
        Schema::create('arrangements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('calendar_id');
            
            $table->dateTime('start');
            $table->dateTime('end');

            $table->unsignedTinyInteger('color')->nullable();
            $table->char('name', 100);
            $table->char('description', 200)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('arrangements');
    }
}
