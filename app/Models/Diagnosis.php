<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Penyakit;
use App\Models\DiagnosisDetail;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    protected $fillable = [
        'nama_pasien',
        'usia',
        'jenis_kelamin',
        'user_id',
        'penyakit_id',
        'nilai_akhir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function details()
    {
        return $this->hasMany(DiagnosisDetail::class);
    }
}
