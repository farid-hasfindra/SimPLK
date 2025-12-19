<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = [
        'rekam_medis_id',
        'total_biaya_akhir',
        'metode_bayar',
        'status_bayar',
        'tanggal_bayar',
    ];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
