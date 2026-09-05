<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyakit', function (Blueprint $table) {
            $table->enum('tingkat_keparahan', ['ringan', 'sedang', 'parah'])
                ->default('sedang')
                ->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('penyakit', function (Blueprint $table) {
            $table->dropColumn('tingkat_keparahan');
        });
    }
};
