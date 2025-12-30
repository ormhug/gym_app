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
        Schema::create('gexercises', function (Blueprint $table) {
        // кастомный PK для связи
            $table->id('guest_exercise_id');
        
        // Связь с таблицей guests (указываем таблицу и её PK)
            $table->foreignId('guest_id')
                ->constrained('guests', 'guest_id')
                ->onDelete('cascade');

        // Связь с таблицей exercises
            $table->foreignId('exercise_id')
                ->constrained('exercises', 'exercise_id')
                ->onDelete('cascade');

            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gexercises');
    }
};
