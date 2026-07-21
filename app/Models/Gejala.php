<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gejala extends Model
{
    protected $table = 'gejala';

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'bobot',
    ];

    public function nilaiKecocokan(): HasMany
    {
        return $this->hasMany(NilaiKecocokan::class);
    }

    public function diagnosisDetail(): HasMany
    {
        return $this->hasMany(DiagnosisDetail::class);
    }
}
