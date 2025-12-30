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
        Schema::create('gsupplies', function (Blueprint $table) {
        
            $table->id('guest_supply_id');
        
        // Связь с таблицей guests
            $table->foreignId('guest_id')
                ->constrained('guests', 'guest_id')
                ->onDelete('cascade');

        // Связь с таблицей supplies
            $table->foreignId('supply_id')
                ->constrained('supplies', 'supply_id')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gsupplies');
    }
};
