<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'jadwal_id',
        'hewan_id',
        'tanggal_booking',
        'no_antrean',
        'status',
        'keluhan_awal',
    ];

    public function jadwalPraktek()
    {
        return $this->belongsTo(JadwalPraktek::class, 'jadwal_id');
    }

    public function hewan()
    {
        return $this->belongsTo(Hewan::class);
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class);
    }
}
