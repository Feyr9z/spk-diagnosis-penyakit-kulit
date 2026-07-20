<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penyakit;
use App\Models\Gejala;

class NilaiKecocokan extends Model
{
    protected $table = 'nilai_kecocokan';

    protected $fillable = [
        'penyakit_id',
        'gejala_id',
        'nilai',
    ];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
