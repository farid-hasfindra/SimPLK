<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'booking_id',
        'tanggal_periksa',
        'diagnosa',
        'tindakan',
        'biaya_tindakan',
        'catatan_dokter',
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function detailResep()
    {
        return $this->hasMany(DetailResep::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public function getTotalBiayaAttribute()
    {
        return $this->biaya_tindakan + $this->detailResep->sum('sub_total');
    }
}
