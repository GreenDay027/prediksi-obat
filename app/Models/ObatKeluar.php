<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatKeluar extends Model
{
    use HasFactory;

    protected $table = 'obat_keluar';

    protected $fillable = [
        'obat_id', 'jumlah', 'tanggal'
    ];

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class, 'obat_id', 'id');
    }
}
