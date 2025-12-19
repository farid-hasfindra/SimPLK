<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPraktek extends Model
{
    use HasFactory;

    protected $table = 'jadwal_praktek';

    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota_harian',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'jadwal_id');
    }
}
