<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisDetail extends Model
{
    protected $table = 'diagnosis_detail';

    protected $fillable = [
        'diagnosis_id',
        'gejala_id',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
