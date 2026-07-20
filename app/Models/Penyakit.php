<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NilaiKecocokan;
use App\Models\Diagnosis;

class Penyakit extends Model
{
    protected $table = 'penyakit';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'solusi',
    ];

    public function nilaiKecocokan()
    {
        return $this->hasMany(NilaiKecocokan::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(Diagnosis::class);
    }
}
