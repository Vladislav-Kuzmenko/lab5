<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('city', 50);
            $table->integer('founded_year');
            $table->string('stadium', 100);
            $table->integer('points')->default(0); // <-- Перевірте, щоб цей рядок був присутній
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
