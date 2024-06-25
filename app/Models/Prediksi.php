<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;

    protected $table = 'prediksi';
    protected $fillable = [
        'data_obat_id',
        'bulan',
        'tahun',
        's1',
        's2',
        's3',
        'at',
        'bt',
        'ct',
        'prediksi',
    ];

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class);
    }
}
