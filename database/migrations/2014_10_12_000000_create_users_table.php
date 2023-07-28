<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('login')->unique();
            $table->string('email')->unique();

            $table->integer('group_id')->default(1);

            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();

            $table->string('phone')->nullable();
            $table->string('telegram_nickname')->nullable();

            $table->string('avatar')->nullable();
            $table->boolean('active')->default(true);

            $table->string('password');
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
