<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'idkategori';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_kategori'
    ];

    /**
     * Relasi dengan Buku (One to Many)
     */
    public function buku()
    {
        return $this->hasMany(Buku::class, 'idkategori', 'idkategori');
    }
}