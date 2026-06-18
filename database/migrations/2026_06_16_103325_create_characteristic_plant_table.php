<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characteristic_plant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('plants')->onDelete('cascade');
            $table->foreignId('characteristic_id')->constrained('characteristics')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['plant_id', 'characteristic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characteristic_plant');
    }
};