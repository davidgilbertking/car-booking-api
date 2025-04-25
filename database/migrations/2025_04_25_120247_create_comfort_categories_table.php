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
        Schema::create('comfort_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Например: "Первая", "Вторая", "Третья"
            $table->unsignedTinyInteger('level')->unique(); // Можно использовать для сортировки
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comfort_categories');
    }
};
