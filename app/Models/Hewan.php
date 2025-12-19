<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hewan extends Model
{
    use HasFactory;
    protected $table = 'hewan';
    protected $fillable = [
        'pelanggan_id',
        'nama_hewan',
        'jenis_hewan',
        'ras',
        'tanggal_lahir',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    function getUsia($tanggalLahir)
    {
        if (!$tanggalLahir) {
            return '-';
        }

        return Carbon::parse($tanggalLahir)->age . ' tahun';
    }


    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
