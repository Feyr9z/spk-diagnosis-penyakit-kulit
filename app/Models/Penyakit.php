<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyakit extends Model
{
    protected $table = 'penyakit';

    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'deskripsi',
        'tingkat_keparahan',
    ];

    public function nilaiKecocokan(): HasMany
    {
        return $this->hasMany(NilaiKecocokan::class);
    }

    public function diagnosis(): HasMany
    {
        return $this->hasMany(Diagnosis::class);
    }
}
