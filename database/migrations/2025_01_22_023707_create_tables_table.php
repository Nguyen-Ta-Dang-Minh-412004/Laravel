<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('table_number')->nullable()->default(null)->zerofill();
            $table->enum('statust', ['empty', 'booked', 'use', 'broken'])->default('empty');
            $table->integer('price')->nullable();
            $table->tinyInteger('area')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tables');
    }
};
