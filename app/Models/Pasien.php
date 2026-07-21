<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'usia',
    ];

    public function diagnosis(): HasMany
    {
        return $this->hasMany(Diagnosis::class);
    }
}
