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
        Schema::create('diagnosis_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('diagnosis_id')
                ->constrained('diagnosis')
                ->cascadeOnDelete();

            $table->foreignId('gejala_id')
                ->constrained('gejala')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['diagnosis_id', 'gejala_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_detail');
    }
};
