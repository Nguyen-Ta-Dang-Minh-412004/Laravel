<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 50)->nullable();
            $table->enum('possition', ['Quan_ly', 'Nhan_vien'])->nullable();
            $table->integer('password')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
