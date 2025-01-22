<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('std', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
};
