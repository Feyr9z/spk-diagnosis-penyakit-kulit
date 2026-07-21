<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pasien_id')
                ->constrained('pasien')
                ->restrictOnDelete();

            $table->foreignId('penyakit_id')
                ->constrained('penyakit')
                ->restrictOnDelete();

            $table->decimal('nilai_preferensi', 8, 4);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis');
    }
};
