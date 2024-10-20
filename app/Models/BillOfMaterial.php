<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    //ini untuk mengambil data dari tabel produks pada model Produk
    public function produk(){
        return $this->BelongsTo('App\Models\Produk');
    }
    //ini untuk menambahkan data bahan dari bill of material ke tabel bill_of_material_bahan
    public function bahans() {
        return $this->belongsToMany(Bahan::class, 'bill_of_material_bahan')
                    ->withPivot('kuantitas', 'satuan')
                    ->withTimestamps();
    }
    
}
