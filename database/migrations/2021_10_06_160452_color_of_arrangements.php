<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColorOfArrangements extends Migration
{
    public function up()
    {
        Schema::table('arrangements', function (Blueprint $table) {
            $table->string('color')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('arrangements', function (Blueprint $table) {
            $table->string('color')->nullable(true)->change();
        });
    }
}
