<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatMasuk extends Model
{
    use HasFactory;

    protected $table = "obat_masuk";

    protected $fillable = [
        'data_obat_id', 'jumlah', 'tanggal', 'kadaluarsa'
    ];

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class, 'data_obat_id', 'id');
    }
}
