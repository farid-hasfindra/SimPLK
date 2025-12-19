<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    protected $table = 'dokter';
    protected $fillable = [
        'user_id',
        'spesialisasi',
        'no_sip',
        'tarif_dasar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalPrakteks()
    {
        return $this->hasMany(JadwalPraktek::class);
    }
}
