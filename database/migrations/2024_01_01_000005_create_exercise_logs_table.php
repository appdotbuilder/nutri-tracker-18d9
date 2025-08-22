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
        Schema::create('exercise_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('exercise_type')->comment('Type of exercise (running, walking, yoga, etc.)');
            $table->integer('duration_minutes')->comment('Duration in minutes');
            $table->decimal('calories_burned', 8, 2)->comment('Calculated calories burned');
            $table->date('logged_date')->comment('Date when exercise was performed');
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'logged_date']);
            $table->index('logged_date');
            $table->index('exercise_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_logs');
    }
};