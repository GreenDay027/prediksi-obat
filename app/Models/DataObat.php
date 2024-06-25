<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataObat extends Model
{
    use HasFactory;

    protected $table = 'data_obat';
    
    protected $fillable = [
        'nama_obat', 'jenis', 'satuan', 'periode', 'stok_masuk', 'stok_keluar', 'sisa'
    ];

    public function obatMasuk()
    {
        return $this->hasMany(ObatMasuk::class);
    }

    public function obatKeluar()
    {
        return $this->hasMany(ObatKeluar::class);
    }
}
