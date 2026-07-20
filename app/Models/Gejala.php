<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NilaiKecocokan;
use App\Models\DiagnosisDetail;

class Gejala extends Model
{
    protected $table = 'gejala';

    protected $fillable = [
        'kode',
        'nama',
        'bobot',
    ];

    public function nilaiKecocokan()
    {
        return $this->hasMany(NilaiKecocokan::class);
    }

    public function diagnosisDetail()
    {
        return $this->hasMany(DiagnosisDetail::class);
    }
}
