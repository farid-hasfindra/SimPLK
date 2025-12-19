<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResep extends Model
{
    use HasFactory;

    protected $table = 'detail_resep';

    protected $fillable = [
        'rekam_medis_id',
        'barang_id',
        'jumlah',
        'harga_saat_ini',
        'sub_total',
    ];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
