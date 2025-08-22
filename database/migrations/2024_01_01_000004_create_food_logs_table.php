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
        Schema::create('food_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('Name of food or drink item');
            $table->decimal('calories', 8, 2)->comment('Calories consumed');
            $table->decimal('protein', 8, 2)->comment('Protein in grams');
            $table->decimal('fat', 8, 2)->comment('Fat in grams');
            $table->decimal('carbohydrates', 8, 2)->comment('Carbohydrates in grams');
            $table->date('logged_date')->comment('Date when food was consumed');
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'logged_date']);
            $table->index('logged_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_logs');
    }
};