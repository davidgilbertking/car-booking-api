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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->unique();
            $table->foreignId('car_model_id')->constrained()->onDelete('cascade');

            // сначала явно nullable без внешнего ключа
            $table->unsignedBigInteger('driver_id')->nullable();

            $table->timestamps();

            // внешний ключ — отдельно, после определения nullable
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
