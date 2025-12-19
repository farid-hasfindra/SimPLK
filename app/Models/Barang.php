<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'kategori',
        'stok',
        'harga_satuan',
        'satuan',
    ];

    public function detailReseps()
    {
        return $this->hasMany(DetailResep::class);
    }
}
