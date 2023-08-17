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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('template_id');
            $table->integer('spot_id');
            $table->integer('secret_guest_id');

            $table->decimal('result')->unsigned()->nullable();
            $table->text('comment')->nullable();
            $table->string('receipt')->nullable();

            $table->date('until_at');
            $table->boolean('closed')->default(false);
            $table->dateTime('closed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
