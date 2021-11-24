<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SharedEvents extends Migration
{
    public function up()
    {
        Schema::create('shared_arrangements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('arrangement_id');
            $table->boolean('can_edit');
            
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('arrangement_id')->references('id')->on('arrangements')->onDelete('cascade');
        });

        Schema::create('shared_reminders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('reminder_id');
            $table->boolean('can_edit');
            
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reminder_id')->references('id')->on('reminders')->onDelete('cascade');
        });

        Schema::create('shared_tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('task_id');
            $table->boolean('can_edit');
            
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });

        Schema::create('shared_calendars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('calendar_id');
            $table->boolean('can_add');
            $table->boolean('can_edit');
            $table->boolean('can_delete');
            
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shared_arrangements');
        Schema::dropIfExists('shared_reminders');
        Schema::dropIfExists('shared_tasks');
        Schema::dropIfExists('shared_calendars');
    }
}
