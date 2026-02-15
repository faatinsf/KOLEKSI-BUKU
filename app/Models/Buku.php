<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'idbuku';
    public $timestamps = false; 

    protected $fillable = [
        'kode',
        'judul',
        'pengarang',
        'idkategori'
    ];

    /**
     * Relasi dengan Kategori (Many to One)
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
    }
}