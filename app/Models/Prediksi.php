<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;

    protected $table = 'prediksi';
    protected $fillable = [
        'nama_obat',
        'bulan_tahun',
        'hasil_prediksi',
        'keterangan'
    ];

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class);
    }
}
