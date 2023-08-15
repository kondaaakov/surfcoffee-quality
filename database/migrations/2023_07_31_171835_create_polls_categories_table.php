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
        Schema::create('polls_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('poll_id');
            $table->integer('category_id');

            $table->decimal('weight')->unsigned()->nullable();
            $table->integer('rate')->unsigned()->nullable();
            $table->decimal('result')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls_categories');
    }
};
