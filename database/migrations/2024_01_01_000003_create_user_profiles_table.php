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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('height', 5, 2)->nullable()->comment('Height in cm');
            $table->decimal('weight', 5, 2)->nullable()->comment('Weight in kg');
            $table->decimal('neck_circumference', 5, 2)->nullable()->comment('Neck circumference in cm');
            $table->decimal('waist_circumference', 5, 2)->nullable()->comment('Waist circumference in cm');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->decimal('body_fat_percentage', 5, 2)->nullable()->comment('Calculated body fat percentage');
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};